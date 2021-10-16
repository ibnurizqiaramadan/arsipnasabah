const BASE_URL = $('meta[name="baseUrl"]').attr("content"),
  API_PATH = BASE_URL + $('meta[name="apiPath"]').attr("content") + "/",
  SLUG = $('meta[name="slug"]').attr("content");

var socket = []

if (typeof io !== 'undefined') {
  socket = io.connect(`https://socket.xyrus10.com`)
  // socket = io.connect(`http://192.168.1.69:6996`)
  // socket = io.connect(`http://localhost:6996`)
  // socket = io.connect(`https://ipdn-socket.herokuapp.com`)
  socket.on("connect", () => {
    // console.log("socket connected")
    socket.emit("connected", {
      username: "anonim",
      userId: "anonim",
      origin: BASE_URL,
      token: "anonim",
    });
    // socket.emit("connected", USERNAME);
  });
}

moment.locale('en');

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

const nanobar = new Nanobar({
  classname: "loadingGan",
  id: "loadingGan"
});
nanobar.go(80);

$(document).ready(function () {
  nanobar.go(100);

  // $('.ourTeam').slick({
  //   infinite: true,
  //   slidesToShow: 2,
  //   slidesToScroll: 2,
  //   dots: true,
  //   autoplay: true,
  //   mobileFirst: true,
  //   pauseOnFocus: true,
  //   autoplaySpeed: 3000,
  //   speed: 1000,
  //   centerMode: false,
  // });
});

var currentPage = location.href

function loadPage(url, change = false) {
  if (url == currentPage && change == false) return
  nanobar.go(80)
  currentPage = url
  const e = $(`a[href='${url.trim()}']`)
  change == false && window.history.pushState("", "", url)
  $.get(url, function (data) {
    $("#main").html($(data).filter('#main').html())
    $("#heroGan").html($(data).filter('#heroGan').html())
    $(".webTitle").html($(data).filter('title').text())
    $("#customJsNa").html($(data).filter('#customJsNa').html())
  }).fail(function (err) {
    $("#main").html(`${err.statusText}`)
    nanobar.go(100)
    // console.log(err)
  }).done(function () {
    nanobar.go(100)
  })
  change == false && (document.body.scrollTop = 0, document.documentElement.scrollTop = 0)
}

var currentRoom = ''
function moveRoom(room) {
  if (currentRoom != '') socket?.emit('leaveRoom', currentRoom)
  socket?.emit("joinRoom", room)
  currentRoom = room
}

$(document).delegate('a', 'click', function (e) {
  if (!$(this).attr('href').includes(BASE_URL)) return
  if ($(this).attr('target') != '_blank') {
    if ($(this).attr('href').includes('#')) return
    e.preventDefault()
    const url = $(this).attr('href')
    loadPage(url)
  }
})

const select = (el, all = false) => {
  el = el.trim()
  if (all) {
    return [...document.querySelectorAll(el)]
  } else {
    return document.querySelector(el)
  }
}

const on = (type, el, listener, all = false) => {
  let selectEl = select(el, all)
  if (selectEl) {
    if (all) {
      selectEl.forEach(e => e.addEventListener(type, listener))
    } else {
      selectEl.addEventListener(type, listener)
    }
  }
}

setInterval(function () {
  if (currentPage.replace(/#/g, '') != location.href.replace(/#/g, '')) (currentPage = location.href, loadPage(currentPage, true))
}, 200);


// sockect server response
socket.on?.("articleChanged", (idNews) => {
  if (currentRoom != 'news') return
  if (typeof getCategory !== "function") return
  // console.log(`Article changed ${idNews}`);
  nanobar.go(80)
  $.get(location.href, function (data) {
    $("#articleSection").html($(data).find('#articleSection').html())
    getCategory()
    getRecentPost()
    getTags()
  }).fail(function (err) {
    $("#main").html(`${err.statusText}`)
    nanobar.go(100)
    // console.log(err)
  }).done(function () {
    nanobar.go(100)
  })
})

socket.on?.('reloadTeams', () => {
  // alert("hello")
  if (currentRoom != 'aboutus') return
  reloadSlick()
})