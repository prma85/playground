	<html>
<head>
<title>SAS - Auditoria de Sistemas</title>
<link href="global.css" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="logoCagece.png" />
<script type="text/javascript" src="./VT101.js" ></script>
<script type="text/javascript" src="./scriptreplay.js" ></script>
<script type="text/javascript"><!--
window.addEventListener("load", function(evt) {
    vt = new VT100(80, 24, "term");
    vt.clear();
    vt.refresh();
    vt.write(
"\n\n\n" +
" * This javascript terminal window is 80x24 characters, so it might be\n" +
"   best to adjust your terminal window to that size as well using the\n" +
"   following to check:\n" +
"      $ watch \"tput cols; tput lines\"\n" +
" * Start recording:\n" +
"      $ SHELL=/bin/sh TERM=vt100 script -t typescript 2> timingfile\n" +
" * Do your stuff and when done exit script with `exit`, `logout` or\n" +
"   ctrl-d.\n" +
" * To test how your recorded session looks like, use:\n" +
"      $ scriptreplay timingfile typescript\n" +
" * Enter `timingfile` and `typescript` into form above and hit the play\n" +
"   button.\n");
    document.getElementById("stop").addEventListener("click", stop, false);
    document.getElementById("speed").addEventListener('change', set_speed, false);
    document.getElementById("fontsize").addEventListener('change', set_fontsize, false);
    document.getElementById("play").addEventListener("click", play, false);

    var samples = document.querySelectorAll("ul#sample>li>a[id^=\"sample_\"]");
    for (var i = 0; i < samples.length; i++) {
      samples[i].addEventListener('click', function(evt) {
          play_file(evt.target.id.substr(7));
      }, false);
    }
    }, false);

--></script>
</head>

<body>


		<div>
			<!-- Cabe&ccedil;alho -->
			<div style="width: 100%; white-space: nowrap;">
				<div id="titulo"><span style="font-size: 12px; color: #000;">V.: 1.0beta</span>
				</div>

				<div class="topo-sistema">
					<div class="topo-logo-sistema">
						<h1>SAS</h1>
						<h3>Sistema de Acesso de Segurança</h3>
					</div>
					<div class="topo-logo-cagece"><img src="layout-sistemas_r1_c3.jpg" alt="Logo da Cagece" />
					</div>		
				</div>
			
			
				<div align="right" style="font-size: 11px;"><table>
<tbody>
<tr>
<td><img src="icon_intranet.jpg" alt="" onclick="window.open('http://cliquecagece')" style="cursor: pointer;" /></td>
</tr>
</tbody>
</table>
<div class="corpo">
	<fieldset>
	<legend>file input</legend>
	typescript: <input type="file" id="typescript" name="typescript" /><br />
	timingfile: <input type="file" id="timingfile" name="typescript" /><br />
	</fieldset>

	<tt><pre id=term></pre></tt>

	<fieldset>
	<legend>play control</legend>
	<button id="play">play</button>
	<button id="stop">stop</button>
	</fieldset>
	<fieldset>
	<legend>output properties</legend>
	Font size
	<select id="fontsize">
	  <option value="8">8</option>
	  <option value="10">10</option>
	  <option value="12" selected="selected">12</option>
	  <option value="14">14</option>
	  <option value="16">16</option>
	  <option value="18">18</option>
	</select>
	Speed
	<select id="speed">
	  <option value="0.25">slowest</option>
	  <option value="0.5">slower</option>
	  <option value="0.75">slow</option>
	  <option value="1.0" selected="selected">normal</option>
	  <option value="1.5">fast</option>
	  <option value="2.0">faster</option>
	  <option value="4.0">fastest</option>
	</select>
	</fieldset>
</div>
</body>

</html>
