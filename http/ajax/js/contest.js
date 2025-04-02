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

function updateImageRating(imageKey, rating) {
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


function rerenderWinner() {
    const winner = winners[winnerIndex];
    document.getElementById('winnerName').innerText = winner.accountName;
    document.getElementById('winnerMonth').innerText = new Intl.DateTimeFormat('de-DE', { month: 'long', year: 'numeric' }).format(new Date(winner.createdAt));
    document.getElementById('winnerImage').setAttribute('src', winner.imagePath);

    document.getElementById('winnerPrev').style.display = winnerIndex > 0 ? 'block' : 'none';
    document.getElementById('winnerNext').style.display = winnerIndex < winners.length - 1 ? 'block' : 'none';
}

function previousWinner() {
    if (winnerIndex > 0) {
        winnerIndex -= 1;
        rerenderWinner();
    }
    else console.error("No previous image");
}

function nextWinner() {
    if (winnerIndex < winners.length - 1) {
        winnerIndex += 1;
        rerenderWinner();
    }
    else console.error('No next image');
}

function rerenderRating() {
    const rating = ratings[ratingIndex];
    document.getElementById('raitingName').innerText = rating.accountName;
    document.getElementById('ratingImage').setAttribute('src', rating.imagePath);

    document.getElementById('raitingPrev').style.display = ratingIndex > 0 ? 'block' : 'none';
    document.getElementById('ratingNext').style.display = ratingIndex < ratings.length - 1 ? 'block' : 'none';
    displayStars(document.getElementById('rating'), rating.currentRating);
}

function previousRating() {
    if (ratingIndex > 0) {
        ratingIndex -= 1;
        rerenderRating();
    } else {
        console.error("No previous image");
    }
}

function nextRating() {
    if (ratingIndex < ratings.length - 1) {
        ratingIndex += 1;
        rerenderRating();
    } else {
        console.error("No next image");
    }

}

(function() {
    const rater = document.querySelector('#rating');
    createStarRater(rater, 5, 3, newRating => updateImageRating(ratings[ratingIndex].imageKey, newRating));

    if (typeof winner !== 'undefined') rerenderWinner();
    if (typeof ratings !== 'undefined') rerenderRating();
})();