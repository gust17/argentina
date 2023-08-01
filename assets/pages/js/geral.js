let deferredPrompt;

(pushalertbyiw = window.pushalertbyiw || []).push(['onSuccess', callbackOnSuccess]);
(pushalertbyiw = window.pushalertbyiw || []).push(['onFailure', callbackOnFailure]);

function callbackOnFailure(result) {

    if (result.status === 1) {

        $.ajax({
            url: baseURL + 'ajax/push_unsubscriber',
            type: 'GET',

            success: function (callback) {

                console.log('UNSUBSCRIBER!!!');
            },

            error: function (error) {

                console.log(error.responseText);
            }
        });
    }
}

function callbackOnSuccess(result) {

    if (result.alreadySubscribed === false) {

        $.ajax({
            url: baseURL + 'ajax/push_subscriber',
            type: 'POST',
            data: { subscriber_id: result.subscriber_id },
            dataType: 'json',

            success: function (callback) {

                console.log('SUBSCRIBER!!!');
            },

            error: function (error) {

                console.log(error.responseText);
            }
        });
    }
}

window.addEventListener('beforeinstallprompt', function (e) {

    e.preventDefault();

    deferredPrompt = e;
});

const installApp = document.getElementById('installApp');

installApp.addEventListener('click', async () => {

    if (deferredPrompt) {

        deferredPrompt.prompt();

        const { outcome } = await deferredPrompt.userChoice;

        if (outcome === 'accepted') {
            console.log('[PWA] User Accept');
        } else {
            console.log('[PWA] User Not Accept');
        }
    }
});

window.addEventListener('appinstalled', () => {
    deferredPrompt = null;
    console.log('PWA was installed');
});

function initMaskMoney() {
    if (typeof $("[data-plugin='moneymask']")[0] != 'undefined') {
        $("[data-plugin='moneymask']").maskMoney({ allowNegative: true, thousands: '', decimal: '.', affixesStay: false });
    }
}

$(document).on('click', '.copiarLink', function () {

    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($('#linkIndicacao').val()).select();
    document.execCommand("copy");
    $temp.remove();

    // Swal.fire('Copiado!', 'Link de indicação copiado com sucesso!', 'success');

    createNotification('Copiado', 'Link de indicação copiado com sucesso!', '', 'success');

});

$(document).on('click', '.starkpix-criptowallet', function () {

    Swal.fire({
        title: `<img src="` + baseURL + `assets/cliente/default/assets/images/logo-dark.svg" width="250" height="50" alt="" class="img-fluid pt-5">`,
        text: `Sua conta não está habilitada para utilizar a starkpix.criptowallet. Tente novamente em breve.`,
        // icon: 'warning',
    });
});

function createNotification(title, message, icon, type) {

    $.notify({
        icon: icon,
        title: title,
        message: message,
        url: ''
    }, {
        element: 'body',
        type: type,
        allow_dismiss: true,
        placement: {
            from: 'top',
            align: 'right'
        },
        offset: {
            x: 30,
            y: 30
        },
        spacing: 10,
        z_index: 999999,
        delay: 2500,
        timer: 1000,
        url_target: '_blank',
        mouse_over: false,
        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        },
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"><i class="fa fa-' + icon + '"></i></span> ' +
            '<span data-notify="title"><strong>{1}</strong></span> <br /> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
    });
};

$(document).on('click', 'button[load-button="on"]', function (e) {

    let label = '<i class="fa fa-pulse fa-spinner"></i> ';
    label += $(this).attr('load-text');

    $(this).html(label);
    $(this).addClass('disabled');
    $(this).attr('onclick', 'event.preventDefault()');
});
$(document).ready(function () {
    // var footerHeight = $('#footer').height()+$('.footer-logo').height();
    var footerHeight = $('#footer').height() + 100;
    $('#footer').css('opacity', '0');
    $('.pc-container').css('padding-bottom', footerHeight);
    // hide footer
    $('#footer').css('bottom', ((footerHeight) * -1));
    window.onscroll = function (ev) {
        if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 5)) {
            // you're at the bottom of the page show footer
            $('#footer').css('bottom', '0');
            $('#footer').css('opacity', '1');
        } else {
            // hide footer
            $('#footer').css('bottom', ((footerHeight) * -1));
            $('#footer').css('opacity', '0');
        }
    };
});



/* Botão lateral compartilhar link */
var $linkShareButton = $('.linkShareButton');
var $linkShare = $('.linkShare');
var $linkShareClose = $('.linkShareClose');
$linkShareButton.click(function () {
    $linkShare.removeClass('linkShare-off');
    $linkShare.addClass('linkShare-on');
    $linkShareButton.removeClass('linkShareButton-on');
    $linkShareButton.addClass('linkShareButton-off');
});
$linkShareClose.click(function () {
    $linkShare.removeClass('linkShare-on');
    $linkShare.addClass('linkShare-off');
    $linkShareButton.removeClass('linkShareButton-off');
    $linkShareButton.addClass('linkShareButton-on');
});

// Set the date we're counting down to
var countDownDate = new Date("Jan 31, 2022 19:34:00").getTime();

// Update the count down every 1 second
var x = setInterval(function () {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="checkIn"
    // document.getElementById("checkIn-facebook").innerHTML = '<h5><i class="text-secondary fab fa-facebook-messenger"></i>&nbsp;  Restarts in: <b class="text-secondary">' + hours + "h "
    //     + minutes + "m " + seconds + "s " + '</b></h5>';

    // document.getElementById("checkIn-instagram").innerHTML = '<h5><i class="text-secondary fab fa-instagram"></i>&nbsp;  Restarts in: <b class="text-secondary">'+ hours + "h "
    // + minutes + "m " + seconds + "s "+'</b></h5>';

    // document.getElementById("checkIn-whatsapp").innerHTML = '<h5><i class="text-secondary fab fa-whatsapp"></i>&nbsp;  Restarts in: <b class="text-secondary">' + hours + "h "
    //     + minutes + "m " + seconds + "s " + '</b></h5>';

    // If the count down is finished, write some text 
    // if (distance < 0) {
    //     clearInterval(x);

    //     document.getElementById("checkIn-facebook").innerHTML =
    //         `<a class="btn btn-outline-light btn-block" href='https://www.facebook.com/sharer/sharer.php?u=` + encodeURI(linkIndicacaoJS) + `' target='_blank' rel='noopener'>
    //         <i class='fab fa-facebook-messenger'></i>&nbsp;  <span class='text-secondary'>via</span> facebook
    //     </a>`;
    //     // document.getElementById("checkIn-instagram").innerHTML =
    //     //     `<a class="btn btn-outline-light btn-block" href='https://google.com' target='_blank'>
    //     //         <i class='fab fa-instagram'></i>&nbsp;  <span class='text-secondary'>via</span> Instagram
    //     //     </a>`;
    //     document.getElementById("checkIn-whatsapp").innerHTML =
    //         `<a class="btn btn-outline-light btn-block" href='https://wa.me/?text=` + encodeURI(linkIndicacaoJS) + `' target='_blank'>
    //         <i class='fab fa-whatsapp'></i>&nbsp;  <span class='text-secondary'>via</span> whatsapp
    //     </a>`;
    // }
}, 1000);


$(document).on('click', '#dataInfoLogin', function () {

    let _this = $(this);

    if (_this.hasClass('fa-eye')) {

        _this.removeClass();
        _this.addClass('fa fa-eye-slash');
        $('#blockInfoLogin').removeClass();
        $('#blockInfoLogin').addClass('hide-info-block');

    } else {

        _this.removeClass();
        _this.addClass('fa fa-eye');
        $('#blockInfoLogin').removeClass();
    }
});

// function initCityLoginData() {
//     var request = new XMLHttpRequest();
//     request.open('GET', 'https://ipv4.wtfismyip.com/json', true);
//     request.onload = function () {
//         if (this.status >= 200 && this.status < 400) {
//             var data = JSON.parse(this.response);
//             // let localization = data.YourFuckingLocation;
//             let isp = data.YourFuckingISP;
//             let ip = data.YourFuckingIPAddress;
//             let miniLocation = data.YourFuckingLocation.replace(/,.+/g, "$'");
//             // document.getElementById("cidade").innerHTML = localization;
//             document.getElementById("cidade").innerHTML = miniLocation;
//             document.getElementById("isp").innerHTML = isp;
//             document.getElementById("ip").innerHTML = ip;
//         } else { }
//     };
//     request.onerror = function () { };
//     request.send();
// }

// initCityLoginData();


document.addEventListener("DOMContentLoaded", function () {
    $(document).ready(function () {
        let value = 0;
        let countClicked = 0;
        let clicked = false;
        let spinsRemaining = 10;

        function getPosition(position) {
            if (position <= 30) {
                $('.congratulation__note').text('Não foi dessa vez, gire novamente!');
            }
            else {
                $('.congratulation__note').text('Não foi dessa vez, gire novamente!');
            }
            $('.popup').removeClass('active');
            $('.congratulation').fadeIn();
            clicked = false;
            countClicked = 0;
        }

        function updateSpins() {
            $("#remaining-spins").text(spinsRemaining);
        }

        $('.wheel__button').click(function () {
            if (spinsRemaining <= 0) {
                alert("Você não tem créditos para girar a roda.");
                return;
            }

            if (clicked == true) {
                countClicked++;
            }
            else {
                let random = Math.floor(Math.random() * 330 + 30);
                let rotations = Math.floor(Math.random() * 5 + 5);
                value += rotations * 360 + random;
                console.log(`random: ${random}`);
                console.log(`finalPosition: ${value % 360}`);
                $(".wheel__inner").css("transform", `rotate(${value}deg)`);

                $(this).prop("disabled", true);
                setTimeout(() => {
                    getPosition(value % 360);
                    $('.wheel__button').prop("disabled", false);
                }, 5000);

                spinsRemaining--;
                updateSpins();
            }
            clicked = true;
        })

        $('.congratulation__close').click(function () {
            $('.congratulation').fadeOut();
        })

        $('.congratulation').click(function (event) {
            if (event.target != this)
                return;
            $(this).fadeOut();
        })

        updateSpins();
    })
});


$(document).on('click', '.sendQuestion ', function () {

    let optionChecked = $('[name="satisfactionNumber"]:checked').attr('id');
    let textSatisfaction = $('[name="satisfactionText"]').val();

    if (optionChecked == 'null' || typeof optionChecked == 'undefined' || optionChecked == '') {

        Swal.fire('Opppss', 'Para enviar você deve selecionar o nível de satisfação com a Invest. Tente novamente.', 'error');

        return;
    }

    $.ajax({
        url: baseURL + 'ajax/send_satisfaction',
        type: 'POST',
        data: { number: optionChecked, text: textSatisfaction },
        dataType: 'json',

        success: function (callback) {

            if (callback.status == 1) {

                Swal.fire('Parabéns!', 'Obrigado por responder nossa pesquisa de satisfação!', 'success');

                $('.nps').remove();
            } else {

                Swal.fire('Erro', 'Erro ao enviar sua pesquisa: ' + callback.error, 'error');
            }
        },

        error: function (error) {

            console.log(error.responseText);
        }
    });
});

$(document).ready(function () {

    $(".nps.floatingActionButton").click(function () {
        $(".nps.formContainer").addClass("transitionIn").removeClass("transitionOut");
        $(this).removeClass("thankYou")
    });

    $(".nps.close").click(function () {
        $(".nps.formContainer").addClass("transitionOut").removeClass("transitionIn");
        $(".nps.floatingActionButton").text("✨ Ganhe 10pts Score").removeClass("thankYou");
    });

    $(".nps.button").click(function () {
        setTimeout(function () {
            $(".nps.floatingActionButton").fadeOut();
        }, 3000);
        $(".nps.floatingActionButton").addClass("thankYou").text("Obrigado ❤️");
        $(".nps.formContainer").addClass("transitionOut").removeClass("transitionIn");
    });
});