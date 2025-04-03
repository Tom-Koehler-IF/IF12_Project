const chartContainers = document.getElementsByClassName('chart-container');
const resizeObserver = new ResizeObserver(entries => {
    entries.forEach(entry => {
        updateChart(entry.target);
    });
});

for (const container of chartContainers) {
    updateChart(container);
    resizeObserver.observe(container);
}

async function updateChart(target) {
    const width = target.clientWidth;
    // Calculate height as 1/3 of width
    const height = Math.floor(width / 3);;

    const response = await ajax_fetch(`/ajax/admin_sales.php?clientWidth=${width}&clientHeight=${height}`, 'GET', {});

    const html = await response.text();
    target.innerHTML = html;
}
