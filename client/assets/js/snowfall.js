document.addEventListener("DOMContentLoaded", function() {
    const snowfallContainer = document.getElementById("snowfall");

    // Number of snowflakes
    const numSnowflakes = 50;

    // Create snowflakes
    for (let i = 0; i < numSnowflakes; i++) {
        const snowflake = document.createElement("div");
        snowflake.className = "snowflake";
        snowfallContainer.appendChild(snowflake);

        // Randomize size and position
        const size = Math.random() * 20 + 10;
        const left = Math.random() * 100;
        const animationDuration = Math.random() * 5 + 5;

        snowflake.style.width = `${size}px`;
        snowflake.style.height = `${size}px`;
        snowflake.style.left = `${left}%`;
        snowflake.style.animationDuration = `${animationDuration}s`;
    }
});