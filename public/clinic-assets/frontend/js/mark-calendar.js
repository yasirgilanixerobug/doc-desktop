(function ($) {
  Date.prototype.addDays = function (days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
  };

  $.fn.markyourcalendar = function (opts) {
    var prevHtml = `<div id="myc-prev-week">&lsaquo;</div>`;
    var nextHtml = `<div id="myc-next-week">&rsaquo;</div>`;
    var defaults = {
      availability: [[], [], [], [], [], [], []], // list of times that can be selected
      isMultiple: false,
      months: [
        "jan",
        "feb",
        "mar",
        "apr",
        "may",
        "jun",
        "jul",
        "aug",
        "sep",
        "oct",
        "nov",
        "dec",
      ],
      prevHtml: prevHtml,
      nextHtml: nextHtml,
      selectedDates: [],
      startDate: new Date(),
      weekdays: ["sun", "mon", "tue", "wed", "thur", "fri", "sat"],
    };
    var settings = $.extend({}, defaults, opts);
    var html = ``;
    var onClick = settings.onClick;
    var onClickNavigator = settings.onClickNavigator;
    var instance = this;

    // take the moon
    this.getMonthName = function (idx) {
      return settings.months[idx];
    };

    var formatDate = function (d) {
      var date = "" + d.getDate();
      var month = "" + (d.getMonth() + 1);
      var year = d.getFullYear();
      if (date.length < 2) {
        date = "0" + date;
      }
      if (month.length < 2) {
        month = "0" + month;
      }
      return year + "-" + month + "-" + date;
    };
    // Here is the controller to switch weeks
    this.getNavControl = function () {
      var previousWeekHtml =
        `<div id="myc-prev-week-container">` + settings.prevHtml + `</div>`;
      var nextWeekHtml =
        `<div id="myc-prev-week-container">` + settings.nextHtml + `</div>`;
      var monthYearHtml =
        `<div id="myc-current-month-year-container">` +
        this.getMonthName(settings.startDate.getMonth()) +
        " " +
        settings.startDate.getFullYear() +
        `</div>`;

      var navHtml =`<div id="myc-nav-container">` +previousWeekHtml +`
                    ` + monthYearHtml +`
                    ` + nextWeekHtml +`<div style="clear:both;"></div></div>`;
      return navHtml;
    };

    // capture and display the days
    this.getDatesHeader = function () {
      var tmp = ``;
      for (i = 0; i < 4; i++) {
        var d = settings.startDate.addDays(i);
        tmp +=
          ` <div class="myc-date-header" id="myc-date-header-` + i + 
          `"><div class="myc-date-number">` + d.getDate() + `</div>
          <div class="myc-date-display">` + settings.weekdays[d.getDay()] +
          `</div></div>`;
      }
      var ret = `<div id="myc-dates-container">` + tmp + `</div>`;
      return ret;
    };

    // get the available hours on each day of the current week
    this.getAvailableTimes = function () {
      var tmp = ``;
      for (i = 0; i < 5; i++) {
        var tmpAvailTimes = ``;
        $.each(settings.availability[i], function () {
          tmpAvailTimes +=
            ` <a href="javascript:;" class="myc-available-time" data-time="` +
            this + `" data-date="` + formatDate(settings.startDate.addDays(i)) +
            `"> ` + this + ` </a> `;
        });
        tmp +=
          ` <div class="myc-day-time-container" id="myc-day-time-container-` +
          i + `"> ` + tmpAvailTimes + ` <div style="clear:both;"></div></div> `;
      }
      return tmp;
    };

    // set the hours that can be allocated
    this.setAvailability = function (arr) {
      settings.availability = arr;
      render();
    };

    this.clearAvailability = function () {
      settings.availability = [[], [], [], [], [], [], []];
    };

    // when last week was pressed
    this.on("click", "#myc-prev-week", function () {
      let weekStartDate = settings.startDate.getDate();
      let weekStartMonth =  settings.startDate.getMonth();
      let weekStartYear =  settings.startDate.getFullYear();
      let currentDate = new Date();
      let currentDateOnly = currentDate.getDate();
      let currentMonth = currentDate.getMonth();
      let currentYear = currentDate.getFullYear();
      
      if (weekStartDate == currentDateOnly 
        && weekStartMonth == currentMonth
        && weekStartYear == currentYear) {
        return false
      }

      settings.startDate = settings.startDate.addDays(-4);
      instance.clearAvailability();
      render(instance);

      if ($.isFunction(onClickNavigator)) {
        onClickNavigator.call(this, ...arguments, instance);
      }

      getWeeklyAvailableSlots(settings.startDate);
    });

    // when next week is pressed
    this.on("click", "#myc-next-week", function () {
      settings.startDate = settings.startDate.addDays(4);
      instance.clearAvailability();
      render(instance);

      if ($.isFunction(onClickNavigator)) {
        onClickNavigator.call(this, ...arguments, instance);
      }

      getWeeklyAvailableSlots(settings.startDate);
    });

    $('#contact-tab').on("click", function () {
      instance.clearAvailability();
      render(instance);

      if ($.isFunction(onClickNavigator)) {
        onClickNavigator.call(this, ...arguments, instance);
      }

      getWeeklyAvailableSlots(settings.startDate);
    });

    // when buying time
    this.on("click", ".myc-available-time", function () {
      var date = $(this).data("date");
      var time = $(this).data("time");
      var tmp = date + " " + time;
      $('#myc-available-time-container a').removeClass("selected");
      if ($(this).hasClass("selected") ) {
        $(this).removeClass("selected");
      } else {
        $(this).addClass("selected");
      }
       window.location.href = "#";
      if ($.isFunction(onClick)) {
        onClick.call(this, ...arguments, settings.selectedDates);
      }
    });

    var render = function () {
      ret =` <div id="myc-container"><div id="myc-nav-container">` +
        instance.getNavControl() +
        `</div> <div id="myc-week-container"><div id="myc-dates-container">` +
        instance.getDatesHeader() +
        `</div><div id="myc-available-time-container">` +
        instance.getAvailableTimes() +
        `</div> </div> </div> `;
      instance.html(ret);
    };
    render();
  };
})(jQuery);
