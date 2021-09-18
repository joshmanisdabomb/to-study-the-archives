//Tooltip

const tooltip = document.getElementById('gui-tooltip');
const xOffset = 15;
const yOffset = -35;

document.querySelectorAll('[data-mctooltip]').forEach(e => {
    e.addEventListener('mouseover', e => {
        tooltip.innerHTML = e.target.dataset.mctooltip;
        tooltip.style.display = 'block';
    });

    e.addEventListener('mouseout', e => {
        tooltip.style.display = 'none';
    });

    e.addEventListener('mousemove', e => {
        positionTooltip(e.clientX, e.clientY, e.pageX, e.pageY)
    });
});

const positionTooltip = function(clientX, clientY, pageX, pageY) {
    var posX = 0, posY = 0;
    if (pageX || pageY) {
        posX = pageX;
        posY = pageY;
    } else if (clientX || clientY) {
        posX = clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
        posY = clientY + document.documentElement.scrollTop + document.body.scrollTop;
    }
    tooltip.style.position = "absolute";
    tooltip.style.top = (posY + yOffset) + "px";
    tooltip.style.left = (posX + xOffset) + "px";
}

tooltip.style.display = "none";
