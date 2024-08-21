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
            top: "120%",
            left: "16%",
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
            // markers: true
        }
    });

    tl2.to('#fanta', {
        top: "220%",
        left: "41%",
        width: "18vw",
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
            start: '0% 90%',
            end: '100% 100%',
            scrub: 1,
            markers: true
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