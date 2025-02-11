document.addEventListener("DOMContentLoaded", () => {
    const offerBlocks = document.querySelectorAll('.g5oXi5dh9a_profile-offer-online');
    let maxHeight = 0;
    offerBlocks.forEach(block => {
        block.style.height = 'auto';
        const height = block.offsetHeight;
        if (height > maxHeight) {
            maxHeight = height;
        }
    });
    offerBlocks.forEach(block => {
        block.style.height = `${maxHeight}px`;
    });
});
