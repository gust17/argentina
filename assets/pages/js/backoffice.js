$(document).ready(function () {

    // Slider Swiperjs
    var swiper = new Swiper(".mySwiper", {
        parallax: true,
        speed: 600,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    if (typeof $('.modal-aviso')[0] !== undefined) {

        $('.modal-aviso').modal('show');
    }

    $(document).on('click', '#dataInfoSaldoRendimentos', function(){

        let _this = $(this);

        if(_this.hasClass('fa-eye')){

            _this.removeClass();
            _this.addClass('fa fa-eye-slash');
            $('#blockInfoSaldoRendimento').removeClass();
            $('#blockInfoSaldoRendimento').addClass('hide-info-block');
            $('#blockInfoEntradas24SaldoRendimento').addClass('hide-info-block');
            $('#blockInfoSaidas24SaldoRendimento').addClass('hide-info-block');

        }else{

            _this.removeClass();
            _this.addClass('fa fa-eye');
            $('#blockInfoSaldoRendimento').removeClass('hide-info-block');
            $('#blockInfoEntradas24SaldoRendimento').removeClass('hide-info-block');
            $('#blockInfoSaidas24SaldoRendimento').removeClass('hide-info-block');
        }
    });

    $(document).on('click', '#dataInfoSaldoRede', function(){

        let _this = $(this);

        if(_this.hasClass('fa-eye')){

            _this.removeClass();
            _this.addClass('fa fa-eye-slash');
            $('#blockInfoSaldoRede').removeClass();
            $('#blockInfoSaldoRede').addClass('hide-info-block');
            $('#blockInfoEntradas24SaldoRede').addClass('hide-info-block');
            $('#blockInfoSaidas24SaldoRede').addClass('hide-info-block');

        }else{

            _this.removeClass();
            _this.addClass('fa fa-eye');
            $('#blockInfoSaldoRede').removeClass('hide-info-block');
            $('#blockInfoEntradas24SaldoRede').removeClass('hide-info-block');
            $('#blockInfoSaidas24SaldoRede').removeClass('hide-info-block');
        }
    });

    $(document).on('click', '#dataInfoUnilevel', function(){

        let _this = $(this);

        if(_this.hasClass('fa-eye')){

            _this.removeClass();
            _this.addClass('fa fa-eye-slash');

            $('#blockTotalRede').addClass('hide-info-block');
            $('#blockDiretosRede').addClass('hide-info-block');
            $('#blockAtivosRede').addClass('hide-info-block');
            $('#blockPendentesRede').addClass('hide-info-block');

        }else{

            _this.removeClass();
            _this.addClass('fa fa-eye');

            $('#blockTotalRede').removeClass('hide-info-block');
            $('#blockDiretosRede').removeClass('hide-info-block');
            $('#blockAtivosRede').removeClass('hide-info-block');
            $('#blockPendentesRede').removeClass('hide-info-block');
        }
    });

    $(document).on('click', '#dataInfoScore', function(){

        let _this = $(this);

        if(_this.hasClass('fa-eye')){

            _this.removeClass();
            _this.addClass('fa fa-eye-slash');
            $('#blockInfoScore').removeClass();
            $('#blockInfoScore').addClass('hide-info-block');

        }else{

            _this.removeClass();
            _this.addClass('fa fa-eye');
            $('#blockInfoScore').removeClass('hide-info-block');
        }
    });

    if (paymentBusinessDay == 1) {
        var daysINeed = [1, 2, 3, 4, 5];
    } else {
        var daysINeed = [0, 1, 2, 3, 4, 5, 6];
    }

    function isThisInFuture(targetDayNum) {

        const todayNum = moment().isoWeekday();

        if (todayNum <= targetDayNum) {
            return moment().isoWeekday(targetDayNum);
        }
        return false;
    }

    function findNextInstanceInDaysArray(daysArray) {

        const tests = daysINeed.map(isThisInFuture);

        const thisWeek = tests.find((sample) => {
            return sample instanceof moment
        });

        return thisWeek || moment().add(1, 'weeks').isoWeekday(daysINeed[0]);
    }
    let nextDayMoment = findNextInstanceInDaysArray(daysINeed);

    let newDateConfig = nextDayMoment.format("YYYY/MM/DD") + ' ' + horaRendimento;

    $("#proximo_rendimento")
        .countdown(newDateConfig, function (event) {

            let configTime = '<div class="col">';
            configTime += '<h3 class="m-0" style="display:inline;">%D dias </h3>';
            configTime += '<h3 class="m-0" style="display:inline;">%Hh</h3>';
            configTime += '<h3 class="m-0" style="display:inline;">%Mm</h3>';
            configTime += '<h3 class="m-0" style="display:inline;">%Ss</h3>';
            configTime += '</div>';

            $(this).html(
                event.strftime(configTime)
            );
        });

    // var tour = new Tour({
    //     name: 'TourLocalHost1',
    //     template: "<div class='popover tour'>\
    //     <div class='arrow'></div>\
    //     <h3 class='popover-title'></h3>\
    //     <div class='popover-content'></div>\
    //     <div class='popover-navigation'>\
    //       <button class='btn btn-default' data-role='prev'>" + __TRANS_TOUR_ANTER__ + "</button>\
    //       <button class='btn btn-default' data-role='next'>" + __TRANS_TOUR_PROX__ + "</button>\
    //       <button class='btn btn-default' data-role='end'>" + __TRANS_TOUR_ENCERRAR__ + "</button>\
    //     </div>\
    //     </div>",
    //     steps: [{
    //             element: ".menuTour",
    //             title: __TRANS_TOUR_MENU_NAVEGACAO_TITLE__,
    //             content: __TRANS_TOUR_MENU_NAVEGACAO_CONTENT__,
    //             placement: 'right',
    //             backdrop: true
    //         },
    //         {
    //             element: ".notificacaoTour",
    //             title: __TRANS_TOUR_MINHAS_NOTIFICACOES_TITLE__,
    //             content: __TRANS_TOUR_MINHAS_NOTIFICACOES_CONTENT__,
    //             placement: 'bottom',
    //             backdrop: true
    //         },
    //         {
    //             element: ".copiarLink",
    //             title: __TRANS_TOUR_LINK_INDICACAO_TITLE__,
    //             content: __TRANS_TOUR_LINK_INDICACAO_CONTENT__,
    //             placement: 'bottom',
    //             backdrop: true
    //         },
    //         {
    //             element: ".proximoRendimento",
    //             title: __TRANS_TOUR_PROXIMO_RENDIMENTO_TITLE__,
    //             content: __TRANS_TOUR_PROXIMO_RENDIMENTO_CONTENT__,
    //             placement: 'left',
    //             backdrop: true
    //         },
    //         {
    //             element: ".saldoRendimento",
    //             title: __TRANS_TOUR_SALDO_RENDIMENTO_TITLE__,
    //             content: __TRANS_TOUR_SALDO_RENDIMENTO_CONTENT__,
    //             placement: 'top',
    //             backdrop: true
    //         },
    //         {
    //             element: ".saldoRede",
    //             title: __TRANS_TOUR_SALDO_REDE_TITLE__,
    //             content: __TRANS_TOUR_SALDO_REDE_CONTENT__,
    //             placement: 'top',
    //             backdrop: true
    //         }
    //     ]
    // });

    // tour.init();
    // tour.start();

    function atropos3d(elemento){
		const myAtropos = Atropos({
		el: elemento,
		activeOffset: 40,
		shadowScale: 0.5,
        // alwaysActive: false,
        // rotate:true,
        rotateXMax:3,
        rotateYMax:5,
        rotateXInvert: false,
        rotateYInvert: true,
        stretchX:20,
        stretchY:20,
        commonOrigin: true,
        rotateTouch:false,
        shadow:true,
        highlight:true
		});
	}
	
	$('div[id^="label_"]').each(function(){

		var splitItem = $(this).attr('id').split('_');
		var nItem = splitItem[1];

		var elementoName = $(this).attr('id');
		$('#'+elementoName+' img').attr('src', baseURL+'assets/cliente/default/assets/images/icons/64px/'+nItem+'.svg');

		$('#'+elementoName+' .level').html('Level '+nItem);
		
		atropos3d('#'+elementoName);
	});
});