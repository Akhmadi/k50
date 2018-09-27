
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import utils from './utils';
import PageApp from './components/page-app';
import VueTheMask from 'vue-the-mask';
window.smoothScroll = require( 'smoothscroll' );

window.videojs = require('video.js');
window.Vue = require('vue');

window.Masonry = require('masonry-layout');
Vue.use(VueTheMask);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// function asyncRequire (cb) {
//     require.ensure([], cb);
// }

const app = new Vue(PageApp);

utils.onReady(()=>{
    let btnToUp = document.querySelector('.fixed_up_button');

    btnToUp.addEventListener('click', (e)=>{
        smoothScroll( document.getElementById('app'), 1000);

        e.preventDefault();
    }, false);

    window.onscroll = ()=>{
        let scrolled = window.pageYOffset || document.documentElement.scrollTop;

        if (scrolled > 0 ){
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }

        if (scrolled >= (window.innerHeight || document.documentElement.clientHeight)){
            document.body.classList.add('screen-scrolled');
        } else {
            document.body.classList.remove('screen-scrolled');
        }
    };

    utils.forEach(document.querySelectorAll('.share-data'), (el)=>{

        el.addEventListener('click',(e)=>{


            e.preventDefault();

            let provider = el.getAttribute('data-provider');

            if (provider) {
                try{
                    utils.sharer()[provider](
                        el.getAttribute('data-url'),
                        el.getAttribute('data-title'),
                        el.getAttribute('data-image'),
                        el.getAttribute('data-desc')
                    );
                } catch(e) {
                    console.log(e.message);
                }
            }
        },false);
    });

    if (document.querySelector('.main__block .main__slider')){
        let mainSlider = new Swiper('.main__block .main__slider', {
            pagination: '.main__block .main__slider .pagination',
            paginationClickable: true,
            slidesPerView: 1,
            autoplay: 4000,
            loop: true,
        });

        // let scrollQuotes = new Swiper('.quotes', {
        //     mode: 'vertical',
        //     scrollContainer: true,
        //     mousewheelControl: true,
        //     scrollbar: {
        //         container: '.swiper-scrollbar'
        //     }
        // });


    }

    if (document.querySelector('.life__section .gallery')){
        let msnry = new Masonry( document.querySelector('.life__section .gallery'), {
            itemSelector: '.life__section .gallery .gallery_item',
            itemSizer: '.life__section .gallery .gallery_sizer',
            percentPosition: true
        });
    }

    if (document.querySelector('.our__speakers.swiper-container')){
        let speakersSlider = new Swiper('.our__speakers.swiper-container', {
            slidesPerView: 6,
            autoplay: 4000,
            loop: true,
            cssWidthAndHeight: 'height'
        });
    }

    if (document.querySelector('.our__partners.swiper-container')){
        let partnersSlider = new Swiper('.our__partners.swiper-container', {
            slidesPerView: 4,
            autoplay: 4000,
            loop: true,
            cssWidthAndHeight: 'height'
        });
    }

    let showModalButtons = document.querySelectorAll('.btn.show-modal, .btn.close-modal, .js-toggle-modal');

    showModalButtons.forEach((b)=>{
        b.addEventListener('click',(e)=>{
            e.preventDefault();
            e.stopPropagation();

            document.querySelector(b.getAttribute('data-modalclass')).classList.toggle('is__active');
        }, false);
    });

    let tabControls = document.querySelectorAll('.tabs');


    if (tabControls)
        tabControls.forEach((t)=>{


            t.querySelectorAll('.tab__header > .tab').forEach((hTab)=>{
                hTab.addEventListener('click',(e)=>{
                    e.preventDefault();
                    e.stopPropagation();

                    t.querySelectorAll('.tab__header .tab.is__active').forEach((hActiveTab)=>{
                        hActiveTab.classList.remove('is__active');
                    });
                    hTab.classList.add('is__active');
                    let tabId = hTab.getAttribute('data-tab-id');

                    t.querySelectorAll('.tab__content > .tab.is__active').forEach((hActiveTab)=>{
                        hActiveTab.classList.remove('is__active');
                    });

                    t.querySelector('.tab__content .tab[data-tab-id="' + tabId + '"]').classList.add('is__active');
                }, false);
            });
        });
    // videojs.autoSetup();

    let videoContainers = document.querySelectorAll('.video-container');

    if (videoContainers.length) {



    //     new Promise((resolve, reject) => {
    //         require.ensure([], () => {
    //             resolve(require('video.js'))
    //         }, baseUrl + "/js/vendor/video.js/video")
    //     }).then((videojs)=>{
    //         window.videojs = videojs;
    //
            videoContainers.forEach(v=>{
                v.classList.add('is__active');
                videojs(v);
            });
    //     })
    }

    let macyContainers = document.querySelectorAll('.macy-container');

    if (macyContainers.length){

        utils.forEach(macyContainers, (macyContainerElement)=>{
            let macyContainer = new Macy({
                container: '.macy-container',
                trueOrder: false,
                waitForImages: false,
                useOwnImageLoader: false,
                debug: true,
                mobileFirst: true,
                columns: 1,
                margin: 24,
                breakAt: {
                    1200: 6,
                    940: 5,
                    520: 3,
                    400: 2
                }
            });
        });
    }
    
    if (document.querySelector('.checkbox')){
       
        let checker = document.getElementById('confirm');
        let sendbtn = document.getElementById('btn_stdt_form');
        checker.onchange = function() {
            if (this.checked){
                sendbtn.classList.add('is__red');
                sendbtn.disabled = false;
            }
            else {
                sendbtn.classList.remove('is__red');
                sendbtn.disabled = true;
            }
            
        };
    };



    let packageList = document.getElementById('packages');
    let packageInfo = document.getElementById('package_info');

    if (packageList){
        packageList.selectedIndex = -1;
        
        packageList.onchange = function(){
            if (packageInfo){
                packageInfo.innerHTML = packageList.value;       
            }
        }
    }


});


