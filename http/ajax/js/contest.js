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
    const winner = jstack.winners[jstack.winnerIndex];
    document.getElementById('winnerName').innerText = winner.accountName;
    document.getElementById('winnerMonth').innerText = new Intl.DateTimeFormat('de-DE', { month: 'long', year: 'numeric' }).format(new Date(winner.createdAt));
    document.getElementById('winnerImage').setAttribute('src', winner.imagePath);

    document.getElementById('winnerPrev').style.display = jstack.winnerIndex > 0 ? 'block' : 'none';
    document.getElementById('winnerNext').style.display = jstack.winnerIndex < jstack.winners.length - 1 ? 'block' : 'none';
}

function previousWinner() {
    if (jstack.winnerIndex > 0) {
        jstack.winnerIndex -= 1;
        rerenderWinner();
    }
    else console.error("No previous image");
}

function nextWinner() {
    if (jstack.winnerIndex < jstack.winners.length - 1) {
        jstack.winnerIndex += 1;
        rerenderWinner();
    }
    else console.error('No next image');
}

function rerenderRating() {
    const rating = jstack.ratings[jstack.ratingIndex];
    document.getElementById('raitingName').innerText = rating.accountName;
    document.getElementById('ratingImage').setAttribute('src', rating.imagePath);

    document.getElementById('raitingPrev').style.display = jstack.ratingIndex > 0 ? 'block' : 'none';
    document.getElementById('ratingNext').style.display = jstack.ratingIndex < jstack.ratings.length - 1 ? 'block' : 'none';
    displayStars(document.getElementById('rating'), rating.currentRating);
}

function previousRating() {
    if (jstack.ratingIndex > 0) {
        jstack.ratingIndex -= 1;
        rerenderRating();
    } else {
        console.error("No previous image");
    }
}

function nextRating() {
    if (jstack.ratingIndex < jstack.ratings.length - 1) {
        jstack.ratingIndex += 1;
        rerenderRating();
    } else {
        console.error("No next image");
    }

}

(function() {
    const rater = document.querySelector('#rating');
    if (rater) createStarRater(rater, 5, 3, newRating => updateImageRating(jstack.ratings[jstack.ratingIndex].imageKey, newRating));

    if (typeof jstack.winners !== 'undefined') rerenderWinner();
    if (typeof jstack.ratings !== 'undefined') rerenderRating();
})();