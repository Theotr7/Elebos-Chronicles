let scrollIndex = 0;
const visibleItems = 3;

function scrollCarousel(direction) {
const track = document.getElementById('boosterCarousel');
const items = track.querySelectorAll('.carousel-item');
const itemWidth = items[0].offsetWidth + 32; // item width + gap
const maxIndex = items.length;

scrollIndex += direction;

if (scrollIndex < 0) {
scrollIndex = maxIndex - visibleItems;
}
if (scrollIndex > maxIndex - visibleItems) {
scrollIndex = 0;
}

track.style.transform = `translateX(-${
scrollIndex * itemWidth
}px)`;
}