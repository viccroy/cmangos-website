/**
* @package   cmangos-website
* @version   1.0
* @author    Viccroy
* @copyright 2023 Viccroy
* @link      https://github.com/viccroy/cmangos-website/
* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
**/

const tooltip = {
    mouseX: -1,
    mouseY: -1,
    hovering: false,
    element: null,
    targets: null,
    process: () => {
        if (!/Mobi/i.test(navigator.userAgent) && tooltip.targets) {
            tooltip.hovering = false;
            tooltip.targets.forEach(target => {
                let bounds = target.getBoundingClientRect();
                if (tooltip.mouseX >= bounds.left && tooltip.mouseX <= bounds.right && tooltip.mouseY >= bounds.top && tooltip.mouseY <= bounds.bottom) {
                    tooltip.hovering = true;
                    if (!tooltip.element) {
                        tooltip.element = document.createElement("div");
                        tooltip.element.classList.add("tooltip");
                        document.body.appendChild(tooltip.element);
                    }
                    tooltip.element.innerHTML = target.getAttribute("data-tooltip");

                    let left = tooltip.mouseX + window.scrollX + 13 * 100 / Math.round(window.devicePixelRatio * 100);
                    let top = tooltip.mouseY + window.scrollY + 23 * 100 / Math.round(window.devicePixelRatio * 100);
                    const rect = tooltip.element.getBoundingClientRect();

                    if (left + rect.width > window.scrollX + window.innerWidth) {
                        left = tooltip.mouseX + window.scrollX - rect.width - 3.25 * 100 / Math.round(window.devicePixelRatio * 100);
                    }

                    if (top + rect.height > window.scrollY + window.innerHeight) {
                        top = tooltip.mouseY + window.scrollY - rect.height + 1 * 100 / Math.round(window.devicePixelRatio * 100);
                    }

                    tooltip.element.style.left = `${left}px`;
                    tooltip.element.style.top = `${top}px`;
                }
            });
    
            if (tooltip.element && !tooltip.hovering) {
                tooltip.element.remove();
                tooltip.element = null;
            }
        }
    }
};

window.onload = () => {
    tooltip.targets = document.querySelectorAll("[data-tooltip]");
    if (/Mobi/i.test(navigator.userAgent)) {
        tooltip.targets.forEach(target => {
            target.addEventListener("click", (e) => {
                if (!tooltip.element) {
                    tooltip.element = document.createElement("div");
                    tooltip.element.classList.add("tooltip");
                    document.body.appendChild(tooltip.element);
                }
                tooltip.element.innerHTML = target.getAttribute("data-tooltip");
                const zoom = window.orientation === 90 || window.orientation === -90 ? 1/0.8 : 1/0.4;
                tooltip.element.style.left = e.x * zoom + window.scrollX * zoom + "px";
                tooltip.element.style.top = e.y * zoom + window.scrollY * zoom + "px";
            });
            target.addEventListener("mouseleave", () => {
                tooltip.element.remove();
                tooltip.element = null;
            });
        });
    }
};

window.onscroll = () => {
    if (!/Mobi/i.test(navigator.userAgent))
        tooltip.process();
}

window.onmousemove = (e) => {
    if (!/Mobi/i.test(navigator.userAgent)) {
        tooltip.mouseX = e.clientX;
        tooltip.mouseY = e.clientY;
        tooltip.process();
    }
};