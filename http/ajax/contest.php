<?php
define('UPDATE_CONFIRMATION_ACTION', 'UPDATE_CONFIRMATION');
define('SUBMIT_IMAGE_ACTION', 'SUBMIT_IMAGE');
define('RATE_IMAGE_ACTION', 'UPDATE_RATING');

session_start();

require_once __DIR__ . '/../repository/login.php';
require_once __DIR__ . '/../repository/contest.php';

$user = getCurrentUser();

$showAdminPage = $user != null && $user->getIsAdmin();
// Show winner if bool is set or we are not logged in
$showWinner = !empty($_GET['showWinner']) || $user == null;

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
            <img style="width: 60px; height: 60px;" src="images/arrow_white2.png" alt="Previous"></img>
        </button>
        <img id="winnerImage" style="max-height: 75%; max-width: 75%; height: auto; width: auto;">
        <button id="winnerNext" onclick="nextImage()" class="btn btn-success" style="border-radius: 50%; width: 75px; height:75px; display: flex; justify-content: center; align-items: center;">
            <img style="width: 60px; height: 60px;" src="images/arrow_white.png" alt="Next"></img>
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
                    <svg fill="#e01b24" width="64px" height="64px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect id="Icons" x="-256" y="-256" width="1280" height="800" style="fill:none;"></rect> <g id="Icons1" serif:id="Icons"> <g id="Strike"> </g> <g id="H1"> </g> <g id="H2"> </g> <g id="H3"> </g> <g id="list-ul"> </g> <g id="hamburger-1"> </g> <g id="hamburger-2"> </g> <g id="list-ol"> </g> <g id="list-task"> </g> <g id="trash"> </g> <g id="vertical-menu"> </g> <g id="horizontal-menu"> </g> <g id="sidebar-2"> </g> <g id="Pen"> </g> <g id="Pen1" serif:id="Pen"> </g> <g id="clock"> </g> <g id="external-link"> </g> <g id="hr"> </g> <g id="info"> </g> <g id="warning"> </g> <g id="plus-circle"> </g> <path id="denied" d="M32.266,7.951c13.246,0 24,10.754 24,24c0,13.246 -10.754,24 -24,24c-13.246,0 -24,-10.754 -24,-24c0,-13.246 10.754,-24 24,-24Zm-15.616,11.465c-2.759,3.433 -4.411,7.792 -4.411,12.535c0,11.053 8.974,20.027 20.027,20.027c4.743,0 9.102,-1.652 12.534,-4.411l-28.15,-28.151Zm31.048,25.295c2.87,-3.466 4.596,-7.913 4.596,-12.76c0,-11.054 -8.974,-20.028 -20.028,-20.028c-4.847,0 -9.294,1.726 -12.76,4.596l28.192,28.192Z"></path> <g id="minus-circle"> </g> <g id="vue"> </g> <g id="cog"> </g> <g id="logo"> </g> <g id="radio-check"> </g> <g id="eye-slash"> </g> <g id="eye"> </g> <g id="toggle-off"> </g> <g id="shredder"> </g> <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g> <g id="react"> </g> <g id="check-selected"> </g> <g id="turn-off"> </g> <g id="code-block"> </g> <g id="user"> </g> <g id="coffee-bean"> </g> <g id="coffee-beans"> <g id="coffee-bean1" serif:id="coffee-bean"> </g> </g> <g id="coffee-bean-filled"> </g> <g id="coffee-beans-filled"> <g id="coffee-bean2" serif:id="coffee-bean"> </g> </g> <g id="clipboard"> </g> <g id="clipboard-paste"> </g> <g id="clipboard-copy"> </g> <g id="Layer1"> </g> </g> </g></svg>                </button>
                <img src="<?php echo $imagesToConfirm[0]->getImagePath(); ?>" style="max-height: 75%; max-width: 75%; height: auto; width: auto;">
                <button onclick="updateImageConfirmation(<?php echo $imagesToConfirm[0]->getKey(); ?>, 1)" class="btn btn_success" style="border-radius: 50%; width: 75px; height:75px; display: flex; justify-content: center; align-items: center;">
                    <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#26a269" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>                
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

    <?php if($showWinner):?>
        <button onclick="loadDinnerContest(false)" class="btn btn-success" style="border-radius: 15px; width: 200px; margin-right: 15px;">Go to ongoing Contest</button>
    <?php else: ?>
        <button onclick="loadDinnerContest(true)" class="btn btn-success" style="border-radius: 15px; width: 200px; margin-right: 15px;">Go to Winner</button> 
    <?php endif; ?>

    <?php if($user == null):?>
        <button onclick="redirectToLogin()" class="btn btn-success" style="border-radius: 15px; width: 200px; margin-right: 15px">Login for current Contest</button>
    <?php endif; ?>
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
