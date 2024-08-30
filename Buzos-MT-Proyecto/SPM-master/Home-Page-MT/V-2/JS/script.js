const lenis = new Lenis()

lenis.on('scroll', (e) => {
    console.log(e)
})

function raf(time) {
    lenis.raf(time)
    requestAnimationFrame(raf)
}

requestAnimationFrame(raf)

let mm = gsap.matchMedia();

mm.add("(min-width: 800px)", () => {
    let tl = gsap.timeline({
        scrollTrigger: {
            trigger: '.section1',
            start: '0% 0%',
            end: '310% 70%',
            scrub: 1
        }
    });

    tl.to('#leaf1', {
        top: "120%",
        left: "80%",
        rotate: 90
    }, 'timeO')
        .to('#leaf2', {
            top: "105%",
            left: "5%",
            rotate: 120
        }, 'timeO')
        .to('#fanta', {
            top: "100%",
            left: "5%",
            width: "20vw"
        }, 'timeO')
        .to('#orange2', {
            top: "140%",
            left: "25%",
        }, 'timeO')
        .to('#orange', {
            top: "160%",
            left: "70%",
        }, 'timeO')
});

mm.add("(max-width: 799px)", () => {
    let tl = gsap.timeline({
        scrollTrigger: {
            trigger: '.section1',
            start: '50% 50%',
            end: '130% 50%',
            scrub: 1
        }
    });

    tl.to('#leaf1', {
        top: "120%",
        left: "80%",
        rotate: 90
    }, 'timeO')
        .to('#leaf2', {
            top: "105%",
            left: "5%",
            rotate: 120
        }, 'timeO')
        .to('#fanta', {
            top: "125%",
            left: "5%",
        }, 'timeO')
        .to('#orange2', {
            top: "110%",
            left: "15%",
        }, 'timeO')
        .to('#orange', {
            top: "160%",
            left: "35%",
            width: "65vw"
        }, 'timeO')
});


let mm2 = gsap.matchMedia();

mm2.add("(min-width: 800px)", () => {
    let tl2 = gsap.timeline({
        scrollTrigger: {
            trigger: '.section2',
            start: '50% 50%',
            end: '200% 100%',
            scrub: 1,
        }
    });

    tl2.to('#fanta', {
        top: "180%",
        left: "42%",
        width: "16vw",
    }, 'time1')
        .to('#orange2', {
            top: "220%",
            left: "40%",
            width: "20vw",
        }, 'time1')
        .from('#pineapplecut', {
            y: 500,
            x: -900,
            rotate: -90,
        }, 'time1')
        .from('#pineapple', {
            y: 300,
            x: -700,
            rotate: -90,
        }, 'time1')
        .from('#orangefruit', {
            y: 500,
            x: 900,
            rotate: 90,
        }, 'time1')
        .from('#yellow', {
            y: 300,
            x: 700,
            rotate: 90,
        }, 'time1')
});

mm2.add("(max-width: 799px)", () => {
    let tl2 = gsap.timeline({
        scrollTrigger: {
            trigger: '.section3',
            start: '0% 50%',
            end: '100% 100%',
            scrub: 1,
        }
    });

    tl2.from('#pineapplecut', {
        y: 500,
        x: -900,
        rotate: -90,
    }, 'time1')
        .from('#pineapple', {
            y: 300,
            x: -700,
            rotate: -90,
        }, 'time1')
        .from('#orangefruit', {
            y: 500,
            x: -900,
            rotate: -90,
        }, 'time1')
        .from('#yellow', {
            y: 300,
            x: -700,
            rotate: -90,
        }, 'time1')
        .from('#resp-orange', {
            y: 500,
            x: 900,
            rotate: 90,
        }, 'time1')
        .from('#resp-fanta', {
            top: 250,
            lef: 700,
            rotate: 90,
        }, 'time1')
});

mm.add("(max-width: 799px)", () => {
    let tl = gsap.timeline({
        scrollTrigger: {
            trigger: '.lft.d-flex',
            start: '200% 5%',  // Ajusta estos valores según necesites
            end: '30% 90%',    // Ajusta estos valores según necesites
            scrub: 1,
            pin: true 
        }
    });

    tl.fromTo('#fanta', {
        top: "30%",            // Posición inicial desde arriba
        left: "5%",            // Posición inicial desde la izquierda
        xPercent: 25,          // Ajuste horizontal
        yPercent: -50,         // Ajuste vertical
        width: "60vw",         // Ancho de la imagen
        position: 'absolute',
        zIndex: 10
    }, {
        yPercent: 50,          // Movimiento vertical durante la animación
        xPercent: 30,          // Movimiento horizontal durante la animación (nuevo)
        scale: 1.1,            // Escala final
        rotation: 5,           // Rotación ligera (nuevo)
        ease: 'power1.inOut'   // Suaviza la animación
    }, 'timeO');

    // Animación del blob
    tl.to('#blob', {
        y: "500%",
        scale: 0.5,
        ease: 'power1.inOut'
    }, 'timeO');

    gsap.set('.lft.d-flex', {position: 'relative', overflow: 'hidden'});
});

let nextButton = document.getElementById('next');
let prevButton = document.getElementById('prev');
let carousel = document.querySelector('.carousel');
let listHTML = document.querySelector('.carousel .list');
let seeMoreButtons = document.querySelectorAll('.seeMore');
let backButton = document.getElementById('back');

nextButton.onclick = function () {
    showSlider('next');
}
prevButton.onclick = function () {
    showSlider('prev');
}
let unAcceppClick;
const showSlider = (type) => {
    nextButton.style.pointerEvents = 'none';
    prevButton.style.pointerEvents = 'none';

    carousel.classList.remove('next', 'prev');
    let items = document.querySelectorAll('.carousel .list .item');
    if (type === 'next') {
        listHTML.appendChild(items[0]);
        carousel.classList.add('next');
    } else {
        listHTML.prepend(items[items.length - 1]);
        carousel.classList.add('prev');
    }
    clearTimeout(unAcceppClick);
    unAcceppClick = setTimeout(() => {
        nextButton.style.pointerEvents = 'auto';
        prevButton.style.pointerEvents = 'auto';
    }, 2000)
}
seeMoreButtons.forEach((button) => {
    button.onclick = function () {
        carousel.classList.remove('next', 'prev');
        carousel.classList.add('showDetail');
    }
});
backButton.onclick = function () {
    carousel.classList.remove('showDetail');
}