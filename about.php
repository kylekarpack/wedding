<?php include("header.php"); ?>
<div class="about">
<style>
header {
	display:none;
}
</style>

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src='http://underscorejs.org/underscore-min.js'></script>

<div id='pane'><div id='map'></div></div>

<article>
  <section id='cover' class='cover active'>
    <h1>The Story of Kristin and Kyle</h1>
    <p>by Kristin and Kyle</p>
    <small class='scroll'>Scroll ▼</small>
  </section>
  <section id='kristinBorn'>
    <h2>Kristin</h2>
    <p>February 15, 1991. Kristin Ivarson is born to Eric and Diana Ivarson. She begins a happy life in Somerset in Bellevue, WA</p>
  </section>
  <section id='kyleBorn'>
    <h2>Kyle</h2>
    <p>March 30, 1992. Unbeknownst to Kristin, Kyle is born less than two miles away.</p>
  </section>
  <section id='growing'>
    <h2>Growing up</h2>
    <p>1991 - 2009. Both Kristin and Kyle grew up in Bellevue, but never met here. They even spent time at Newport High School together, but had never yet seen each other.</p>
  </section>
  <section id='uw1'>
    <h2>University of Washington</h2>
    <p>September 2009. Kristin heads to the University of Washington to pursue a degree in Computer Science. She begins attending Mars Hill Church in the University District.</p>
  </section>
  <section id='uw2'>
    <h2>The Next Year...</h2>
    <p>September 2010. Kyle joins her at the UW in the dorm next door, planning to pursue a degree in Human Centered Design and Engineering. The two have still not yet met.</p>
  </section>
  <section id='sight'>
    <h2>The First Sighting</h2>
	<p>Sometime in late 2010. Kristin and Kyle are serving at Mars Hill together, preparing the upstairs apartments for the new round of interns. They see each other for the first time, but being software engineers, do not speak.</p>
  </section>
  <section id='work'>
    <h2>Becoming Friends</h2>
    <p>Working on productions together at Mars Hill, Kristin and Kyle get to spend a lot of time together. They start to become friends!</p>
  </section>
  <section id='friends'>
    <h2>Working in Kirkland</h2>
    <p>During the summer of 2012, Kristin and Kyle both worked in Kirkland, only a few blocks from each other. They get lots of time in the car stuck on 520.</p>
  </section>
  <section id='first-date'>
    <h2>The First Date</h2>
    <p>In July of 2012, Kyle asks Kristin on a date and they go for a fancy seafood dinner, followed by a casual boat-stealing on Lake Sammamish.</p>
  </section>
  <section id='engagement'>
    <h2>The Proposal</h2>
    <p>On March 30th, 2013, Kyle's birthday, he and Kristin pack a picnic lunch and head out to spend the beautiful day at Discovery Park. Up on the bluff, Kyle asks Kristin to marry him, and she says yes!</p>
  </section>
  <section id='wedding'>
    <h2>The Wedding</h2>
    <p>On January 4th, 2014, Kristin and Kyle are getting married! Join us at the Great Hall at Greenlake to celebrate this occasion. <a href="ceremony.php">Learn more here!</a></p>
  </section>
</article>

<script>
$("nav").addClass("specialNav");

var geojson = [
  { "geometry": { "type": "Point", "coordinates": [-122.1994, 47.6106] }, // Bellevue
    "properties": { "id": "cover", "photo":"logo.png", "zoom": 10 } },
  { "geometry": { "type": "Point", "coordinates": [-122.152732, 47.565755] },
    "properties": { "id": "kristinBorn", "photo": "kristin-born.jpg", "marker-symbol": "marker" } },
  { "geometry": { "type": "Point", "coordinates": [-122.177332, 47.562635] },
    "properties": { "id": "kyleBorn", "photo": "kyle-born.jpg" } },
  { "geometry": { "type": "Point", "coordinates": [-122.169159, 47.569782] },
    "properties": { "id": "growing", "photo": "growing-up.jpg" } },
  { "geometry": { "type": "Point", "coordinates": [-122.304774, 47.660496] },
    "properties": { "id": "uw1", "photo": "uw1.jpg" } },
  { "geometry": { "type": "Point", "coordinates": [-122.303647, 47.659267] },
    "properties": { "id": "uw2", "photo": "uw2.jpg" } },
  { "geometry": { "type": "Point", "coordinates": [-122.315182, 47.661784] },
    "properties": { "id": "sight", "photo": "first-sighting.jpg" } },
  { "geometry": { "type": "Point", "coordinates": [-122.315182, 47.661784] },
    "properties": { "id": "work", "photo": "friends.jpg" } },
  {	"geometry": { "type": "Point", "coordinates": [-122.196335, 47.670188] },
    "properties": { "id": "friends", "photo": "google.jpg" } },
  { "geometry": { "type": "Point", "coordinates": [-122.0807039, 47.580391] },
    "properties": { "id": "first-date", "photo": "first-date.jpg"} },
  { "geometry": { "type": "Point", "coordinates": [-122.427, 47.6587964] },
    "properties": { "id": "engagement", "photo": "engagement.jpg"} },
  { "geometry": { "type": "Point", "coordinates": [-122.324901, 47.681102] },
    "properties": { "id": "wedding", "photo": "wedding.jpg"} }
];
var tiles = mapbox.layer().tilejson({
  tiles: [ "http://a.tiles.mapbox.com/v3/examples.map-liczq28b/{z}/{x}/{y}.png" ]
});
var spots = mapbox.markers.layer()
  // Load up markers from geojson data.
  .features(geojson)
  // Define a new factory function. Takes geojson input and returns a
  // DOM element that represents the point.
  .factory(function(f) {
    var el = document.createElement('div');
    el.className = 'spot spot-' + f.properties.id;
	$(el).append($("<div class='imgCont'>"));
	$(el).find("div").append("<img src='img/" + f.properties.photo + "' class='color' />");
    return el;
  });

// Creates the map with tile and marker layers and
// no input handlers (mouse drag, scrollwheel, etc).
var map = mapbox.map('map', [tiles, spots], null, []);

// Array of story section elements.
var sections = document.getElementsByTagName('section');

// Array of marker elements with order matching section elements.
var markers = _(sections).map(function(section) {
  return _(spots.markers()).find(function(m) {
    return m.data.properties.id === section.id;
  });
});

// Helper to set the active section.
var setActive = function(index, ease) {
  // Set active class on sections, markers.
  _(sections).each(function(s) { s.className = s.className.replace(' active', '') });
  _(markers).each(function(m) { m.element.className = m.element.className.replace(' active', '') });
  sections[index].className += ' active';
  markers[index].element.className += ' active';

  // Set a body class for the active section.
  document.body.className = 'section-' + index;

  // Ease map to active marker.
  if (!ease) {
    map.centerzoom(markers[index].location, markers[index].data.properties.zoom||15);
  } else {
    map.ease.location(markers[index].location).zoom(markers[index].data.properties.zoom||15).optimal(.9, 2);
  }

  return true;
};

// Bind to scroll events to find the active section.
window.onscroll = _(function() {
  // IE 8
  if (window.pageYOffset === undefined) {
    var y = document.documentElement.scrollTop;
    var h = document.documentElement.clientHeight;
  } else {
    var y = window.pageYOffset;
    var h = window.innerHeight;
  }

  // If scrolled to the very top of the page set the first section active.
  if (y === 0) return setActive(0, true);

  // Otherwise, conditionally determine the extent to which page must be
  // scrolled for each section. The first section that matches the current
  // scroll position wins and exits the loop early.
  var memo = 0;
  var buffer = (h * 0.3333);
  var active = _(sections).any(function(el, index) {
    memo += el.offsetHeight;
    return y < (memo-buffer) ? setActive(index, true) : false;
  });

  // If no section was set active the user has scrolled past the last section.
  // Set the last section active.
  if (!active) setActive(sections.length - 1, true);
}).debounce(10);

// Set map to first section.
setActive(0, false);

//Click handlers
$("section").click(function() {
	var $active = $("section.active"),
		$this = $(this);
	if ($active.offset().top != $this.offset().top) {
		var t = $active.offset().top === $("section").eq(0).offset().top ? $("section.active").outerHeight() : $this.prev().offset().top ;
		$("body").animate({"scrollTop":t}, 400);
	}	
});

////Arrow key handlers
/*
document.onkeydown = keypress;
function keypress(e) {
	console.log("fire");
	e = e || window.event;
	if (e.keyCode == '38') { // up arrow
		e.preventDefault();
		var t = $("section.active").prev().prev().offset().top;
		$("body").animate({"scrollTop":t}, 400);
	} else if (e.keyCode == '40') { // down arrow
		e.preventDefault();
		var t = $("section.active").offset().top > $("nav").height() ? $("section.active").offset().top : $("section.active").next().outerHeight();
		$("body").animate({"scrollTop":t}, 400);
	}
}
*/
</script>

</div>

<div style="display:none">
	<?php include("footer.html"); ?>
</div>

</body>
</html>