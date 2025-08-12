const currentDate = document.querySelector(".current-date");
const weekday = document.querySelector(".days");
const prevNext = document.querySelectorAll(".icons span");
const weekDays = [0, 1, 2, 3, 4, 5, 6];
const month = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

let disbaleWeekDays = disableWeekDays;//[0, 6];
let disbaleMonthDates = holidays;//['2023-04-26', '2023-04-27', '2023-04-28'];

let date = new Date(),
  currentYear = date.getFullYear(),
  currentMonth = date.getMonth();
let lastMonth = currentMonth - 1;

const isDisableDate = (d1) => {
  let date1 = new Date(d1).toDateString();
  date1 = new Date(date1).getTime();
  let match = 0;
  for (let disableDate of disbaleMonthDates) {
    var date2 = new Date(disableDate).toDateString();
    date2 = new Date(date2).getTime();
    if (date1 === date2) {
      match = 1;
      break;
    }
  }

  return match;
};


// getting date month and current year
const rendCalendar = (activeMonth, activeYear) => {
  let fstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay(); // get fst day of month wed 1
  let lastDateOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate(); //get last date of month 3/31
  let lastDayOfMonth = new Date(
    currentYear,
    currentMonth,
    lastDateOfMonth
  ).getDay(); //get last day of month friday

  let lastDateOfLastMonth = new Date(currentYear, currentMonth, 0).getDate(); //get last day of previous month 2/28
  let liTag = "";
  let otherMonth = activeMonth != undefined ? activeMonth : currentMonth;
  let otherYear = activeYear != undefined ? activeYear : currentYear;
  let todayDate = date.getDate();

  for (let i = fstDayOfMonth; i > 0; i--) {
    // create li of previous month of last days
    liTag += `<li class="inactive day avoid-clicks"><del>${lastDateOfLastMonth - i + 1}</del></li>`;
  }

  for (let i = 1; i <= lastDateOfMonth; i++) {

    let isToday;
    let dateStatus = 1;
    var  dateWeekDay = new Date(otherYear, otherMonth, i).getDay();
    var  loopDate = new Date(otherYear, otherMonth, i);

    let isDisable = isDisableDate(loopDate);

    if (disbaleWeekDays.includes(dateWeekDay)) {
      isToday = "inactive avoid-clicks";
      dateStatus = 0;
      if (i === todayDate) {
        isToday = "inactive avoid-clicks active-date";
        dateStatus = 1;
      }
    } else if (isDisable === 1) {

      isToday = "inactive avoid-clicks";
       dateStatus = 0;
      if (i === todayDate) {
        isToday = "active-date";
         dateStatus = 0;
      }
      
    } else {
      // create li of all days current month
      if (otherMonth < new Date().getMonth() && otherYear <= new Date().getFullYear()) {
        isToday = "inactive";

      } else if (otherYear < new Date().getFullYear()) {
        isToday = "inactive avoid-clicks";

      } else if (
          i < todayDate &&
          currentMonth === new Date().getMonth() &&
          currentYear === new Date().getFullYear()) {

        isToday = "inactive avoid-clicks";
         dateStatus = 0;
      } else {

        isToday =
          i === todayDate &&
          currentMonth === new Date().getMonth() &&
          currentYear === new Date().getFullYear()
            ? "active-date"
            : "";
      }
    }

    if (dateStatus === 0) {
      liTag += `<li class="${isToday} day"><del>${i}</del></li>`;  
    } else {
      liTag += `<li class="${isToday} day">${i}</li>`;  
    }
    
  }

  for (let i = lastDayOfMonth; i < 6; i++) {
    // create li of next month of dyas
    liTag += `<li class="nm-inactive day avoid-clicks">${i - lastDayOfMonth + 1}</li>`;
  }

  currentDate.innerText = `${month[currentMonth]} ${currentYear}`;
  weekday.innerHTML = liTag;
};

rendCalendar();
dayActive();
//appendUl();

prevNext.forEach((icon) => {
  icon.addEventListener("click", () => {
    currentMonth = icon.id === "prev" ? currentMonth - 1 : currentMonth + 1;
    if (currentMonth < 0 || currentMonth > 11) {
      date = new Date(currentYear, currentMonth);
      currentYear = date.getFullYear();
      currentMonth = date.getMonth();
    } else {
      date = new Date();
    }
    prevFun(currentMonth, lastMonth, currentYear);
    rendCalendar(currentMonth, currentYear);
    dayActive();
  });
  prevFun(currentMonth, lastMonth, currentYear);
});

function dayActive() {
  const lis = document.querySelectorAll(".day");
  lis.forEach((li) => {
    if (li.classList.contains("inactive") != true) {
      li.addEventListener("click", function handleClick(event) {
        document.querySelector(".active-date")?.classList.remove("active-date");
        li.classList.add("active-date");
        //appendUl();
      });
    }
  });
}

function appendUl() {
  
  //document.getElementById("time-tab").innerHTML =
    //"<ul><li>12:45 pm</li><li>1:30 pm</li><li>2:15 pm</li><li>3:45 pm</li></ul>";

  const timeTab = document.querySelectorAll(".time-tab ul li");
  timeTab.forEach((li) => {
    if (li.classList.contains("active-slot") != true) {
      li.addEventListener("click", function handleClick(event) {
        document.querySelector(".active-slot")?.classList.remove("active-slot");
        li.classList.add("active-slot");
      });
      // li.addEventListener("click", function handleClick(event){
      //   window.location.href =  "appointment-form.html";
      // })
    }
  });
}

function prevFun(activeMonth, lastMonth, activeYear) {
  let thisYear = date.getFullYear(),
    prevBtn = document.getElementById("prev");
  if (lastMonth + 1 == activeMonth && activeYear <= thisYear) {
    prevBtn.style.pointerEvents = "none";
  } else {
    prevBtn.style.pointerEvents = "auto";
  }
}
