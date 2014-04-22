
function CreateGame(canvas, showfps)
{
	var m_entities = [];
	var m_controls = [];
	var m_canvas = canvas;
	var m_context = canvas.getContext("2d");
	var m_elapsed = 0;
	var m_delta = 0;
	var m_timelast = 0;
	var m_isgameover = false;
	var m_ispaused = false;
	var m_showfps = showfps;

	var Init = function()
	{
		m_entities = [];
		m_isgameover = false;
		m_ispaused = false;
	}

	var Start = function()
	{
		requestAnimationFrame(GameLoop);
	}

	var End = function()
	{
		m_isgameover = true;
	}

	var GameLoop = function(now)
	{
		m_delta = (now - m_timelast) / 1000.0;
		m_timelast = now;

		if(!m_ispaused)
		{
			m_elapsed += m_delta;
			Update();
		}

		if(!m_isgameover)
			requestAnimationFrame(GameLoop);
	}

	var Update = function()
	{
		// Clear the screen
		var ctx = m_context;
		ctx.clearRect(0, 0, m_canvas.width, m_canvas.height);

		// Draw FPS
		if(m_showfps)
		{	
			var text = "FPS: " + Math.round(1.0 / m_delta);
			ctx.font = "1em Arial";

			ctx.lineWidth = 2;
			ctx.strokeStyle = "#000";
			ctx.strokeText(text, 10, 20);

			ctx.fillStyle = "#FFF";
			ctx.fillText(text, 10, 20);
		}

		for(var i in m_entities)
			m_entities[i].Update();
	}

	var Add = function(e)
	{
		e.Game = this;
		m_entities.push(e);
		return e;
	}

	var Count = function()
	{
		return m_entities.length;
	}

	var GetDelta = function()
	{
		return m_delta;
	}

	var GetElapsed = function()
	{
		return m_elapsed;
	}

	window.onkeydown = function(e)
	{
		var key = String.fromCharCode(e.keyCode);

		for(var i in m_controls)
		{
			if(m_controls[i].Key === key)
			{
				m_controls[i].State = true;
				return;
			}
		}
	}

	window.onkeyup = function(e)
	{
		var key = String.fromCharCode(e.keyCode);

		for(var i in m_controls)
		{
			if(m_controls[i].Key === key)
			{
				m_controls[i].State = false;
				return;
			}
		}
	}

	window.onblur = function()
	{
		m_ispaused = true;

		for(var i in m_controls)
		{
			m_controls[i].State = false;
		}
	}

	window.onfocus = function()
	{
		m_ispaused = false;
	}

	return {
		Controls 	: m_controls,
		Context 	: m_context,
		IsGameover 	: m_isgameover,
		IsPaused 	: m_ispaused,

		Init 		: Init,
		Start		: Start,
		End 		: End,
		GetDelta 	: GetDelta,
		GetElapsed 	: GetElapsed,
		Add 		: Add,
		Count 		: Count
	};
}

/*
	controls :
	{
		up : 	{ key : "W", state : false },
		down : 	{ key : "S", state : false },
		left : 	{ key : "A", state : false },
		right : { key : "D", state : false }
	},

	onMouseDown : function(e)
	{
		var rect = game.canvas.getBoundingClientRect();
		var x = Math.min(rect.width, Math.max(0, e.x - rect.left)) / rect.width;
		var y = Math.min(rect.height, Math.max(0, e.y - rect.top)) / rect.height;

		x *= game.canvas.width;
		y *= game.canvas.height;
	},

	onKeyDown : function(e)
	{
		var key = String.fromCharCode(e.keyCode);

		for(var control in game.controls)
		{
			if(key == game.controls[control].key)
			{
				game.controls[control].state = true;
				return;
			}
		}
	},

	onKeyUp : function(e)
	{
		var key = String.fromCharCode(e.keyCode);

		for(var control in game.controls)
		{
			if(key == game.controls[control].key)
			{
				game.controls[control].state = false;
				return;
			}
		}
	},

	onLostFocus : function()
	{
		game.paused = true;

		for(var i in game.controls)
		{
			game.controls[i].state = false;
		}
	},
*/

console.log("loaded: game.js");