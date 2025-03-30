<?php
define('UPDATE_CONFIRMATION_ACTION', 'UPDATE_CONFIRMATION');
define('SUBMIT_IMAGE_ACTION', 'SUBMIT_IMAGE');
define('RATE_IMAGE_ACTION', 'UPDATE_RATING');

session_start();

require_once __DIR__ . '/../repository/login.php';
require_once __DIR__ . '/../repository/contest.php';

$user = getCurrentUser();
if ($user === null) { // TODO require login;
    echo "Unauthorized";
    exit;
}

$showAdminPage = $user->getIsAdmin();
$showWinner = !empty($_GET['showWinner']);

// This is the point where we do POST processing (So basically handle)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {
    case UPDATE_CONFIRMATION_ACTION:
        if (!$showAdminPage) {
            http_response_code(401);
            echo 'Missing admin permissions to delete this';
            exit;
        }
    
        updateContestImageConfirmation($_POST['imageKey'], $_POST['confirmed']);
        break; // break as we just want to still display content like always
    case SUBMIT_IMAGE_ACTION:
        $file = $_FILES['file'];

        submitContestImage($user->getKey(), $file);
        
        exit; // Exit as we do not expect a response
    case RATE_IMAGE_ACTION:
        updateContestImageRating($user->getKey(), $_POST['imageKey'], $_POST['rating']);
        break;
    default:
        echo 'Unkown action: ' . $action;
        http_response_code(400);
        exit;
    }
}

// Do data fetching here for a clear seperation of logic and frontend
if ($showWinner) {
    $winners = getContestWinners();
}
else if ($showAdminPage) {
    $imagesToConfirm = getUnconfirmedContestImages();
} else {
    $imagesToRate = getUnratedContestImages($user->getKey());
}

?>

<?php if($showWinner): ?>
    <div>
        <span style="display: block; font-weight: bold; font-size: 25px;" id="winnerName"></span>
        <span style="display: block; font-weight: bold; font-size: 25px;" id="winnerMonth"></span>
    </div>

    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
        <button id="winnerPrev" onclick="previousImage()" class="btn btn-success" style="border-radius: 50%; width: 75px; height:75px; display: flex; justify-content: center; align-items: center;">
            <img style="width: 60px; height: 60px;" src="images/arrow_previous.png" alt="Previous"></img>
        </button>
        <img id="winnerImage" style="max-height: 75%; max-width: 75%; height: auto; width: auto;">
        <button id="winnerNext" onclick="nextImage()" class="btn btn_success" style="border-radius: 50%; width: 75px; height:75px; display: flex; justify-content: center; align-items: center;">
            <img style="width: 60px; height: 60px;" src="images/arrow_next.png" alt="Next"></img>
        </button>
    </div>
 <?php else: ?>
    <?php if($showAdminPage): ?>
        <?php if (count($imagesToConfirm) == 0):?>
            No pending images
        <?php else: ?>
            <div>
                <span style="display: block; font-weight: bold; font-size: 25px;">Name: <?php echo $imagesToConfirm[0]->getAccountName(); ?></span>
            </div>
    
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                <button onclick="updateImageConfirmation(<?php echo $imagesToConfirm[0]->getKey(); ?>, 0)" class="btn btn-error" style="border-radius: 50%; width: 75px; height:75px; display: flex; justify-content: center; align-items: center;">
                    <img style="width: 60px; height: 60px;" src="Images/deny.png" alt="Deny"></img>
                </button>
                <img src="<?php echo $imagesToConfirm[0]->getImagePath(); ?>" style="max-height: 75%; max-width: 75%; height: auto; width: auto;">
                <button onclick="updateImageConfirmation(<?php echo $imagesToConfirm[0]->getKey(); ?>, 1)" class="btn btn_success" style="border-radius: 50%; width: 75px; height:75px; display: flex; justify-content: center; align-items: center;">
                    <img style="width: 60px; height: 60px;" src="Images/confirm.png" alt="Confirm"></img>
                </button>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if (count($imagesToRate) == 0):?>
            No images left to rate
        <?php else: ?>
            <div>
                <span style="display: block; font-weight: bold; font-size: 25px;">Name: <?php echo $imagesToRate[0]->getAccountName(); ?></span>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
               <img src="<?php echo $imagesToRate[0]->getImagePath(); ?>" style="max-height: 75%; max-width: 75%; height: auto; width: auto;">
           </div>
           <!-- TODO: Display the rating bar and call rateImage -->
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<div style="position: fixed; bottom: 0; right: 0; display: flex; gap: 8px; align-items: center; flex-direction: column; margin-bottom: 15px;">
    <?php if(!$showAdminPage): ?>
        <input class="form-control" type="file" id="formFile" style="margin-right: 15px;" onchange="submitImage(event)"/>
    <?php endif; ?>
    <button onclick="loadDinnerContest(true)" class="btn btn-success" style="border-radius: 15px; width: 200px; margin-right: 15px;">Go to Winner</button> 
</div>    

<script>
// Do some javascript magic. There is only one version that is indepedent of user and admin.
// Backend either way needs to revalidate rights
function updateImageConfirmation(imageKey, confirmed) {
    let params = new URLSearchParams({
        action: 'UPDATE_CONFIRMATION',
        imageKey: imageKey,
        confirmed: confirmed,
    });

    ajax_fetch('/ajax/contest.php', 'POST', {
        'Content-Type': 'application/x-www-form-urlencoded'
    }, params.toString())
        .then(r => r.text())
        .then(loadInnerContent) // loadInnerContent is a global helper function defined in Content Switch logic.
                            // The idea of this is that the same http requerst to update the image already returns the new one
        .catch(console.error);
}

function submitImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);
    formData.append('action', 'SUBMIT_IMAGE');

    ajax_fetch('/ajax/contest.php', 'POST', {}, formData);
}

function rateImage(imageKey, rating) {
    let params = new URLSearchParams({
        action: 'UPDATE_RATING',
        imageKey: imageKey,
        rating: rating,
    });

    // This is a fire and forget as it does not return any nnew content
    ajax_fetch('/ajax/contest.php', 'POST', {
        'Content-Type': 'application/x-www-form-urlencoded'
    }, params.toString());
}

<?php if($showWinner): ?>
    let winners = <?php
        echo '[';
        foreach ($winners as $winner) {
            echo '{ "accountName": "' . $winner->getAccountName() . '", "createdAt": "' . $winner->getCreatedAt()->format(DateTime::ATOM) . '", "imagePath": "' . $winner->getImagePath() . '"},';
        }
        echo ']';
    ?>;
    let winnerIndex = winners.length - 1;

    function rerenderWinner() {
        const winner = winners[winnerIndex];
        document.getElementById('winnerName').innerText = winner.accountName;
        document.getElementById('winnerMonth').innerText = new Intl.DateTimeFormat('de-DE', { month: 'long', year: 'numeric' }).format(new Date(winner.createdAt));
        document.getElementById('winnerImage').setAttribute('src', winner.imagePath);

        document.getElementById('winnerPrev').style.display = winnerIndex > 0 ? 'block' : 'none';
        document.getElementById('winnerNext').style.display = winnerIndex < winners.length - 1 ? 'block' : 'none';
    }

    function previousImage() {
        if (winnerIndex > 0) {
            winnerIndex -= 1;
            rerenderWinner();
        }
        else console.error("No previous image");
    }
    
    function nextImage() {
        if (winnerIndex < winners.length - 1) {
            winnerIndex += 1;
            rerenderWinner();
        }
        else console.error('No next image');
    }

    rerenderWinner();
<?php endif; ?>
</script>
