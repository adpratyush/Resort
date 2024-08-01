window.addEventListener('scroll', () => {
    const header = document.getElementById('header');
    if (window.scrollY > 0) {
        header.style.backgroundColor = '#fff';
    } else {
        header.style.backgroundColor = 'transparent';
    }
});
