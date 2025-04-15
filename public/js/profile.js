// JavaScript to handle the popover visibility
const tooltipTrigger = document.querySelector(
    '[data-tooltip-target="id-popover"]'
);
const tooltip = document.getElementById("id-popover");

tooltipTrigger.addEventListener("mouseenter", () => {
    tooltip.classList.remove("invisible", "opacity-0");
    tooltip.classList.add("visible", "opacity-100");
});

tooltipTrigger.addEventListener("mouseleave", () => {
    tooltip.classList.add("invisible", "opacity-0");
    tooltip.classList.remove("visible", "opacity-100");
});
