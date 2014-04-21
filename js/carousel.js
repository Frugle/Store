
function NewCarousel()
{
	var m_images 	= null;
	var m_urls		= null;
	var m_context 	= null;
	var m_isActive 	= false;
	var m_images 	= null;
	var m_index 	= 0;
	var m_imgCount 	= 0;
	var m_loaded	= 0;
	var m_interval 	= 5000;
	var m_counter 	= 0;
	var m_lastTime 	= 0;
	var m_size 		= null;
	var m_isDrawn	= false;
	var m_colorFG 	= "white";
	var m_colorBG 	= "black";
	var m_showBar	= true;
	var m_barType	= 0;

	var pub_setImages = function(images)
	{
		m_index = 0;
		m_imgCount = images ? images.length : 0;
		m_loaded = 0;
		m_images = [];

		for(var i = 0; i < m_imgCount; i++)
		{
			m_images.push(new Image());
			m_images[i].onload = function() { m_loaded++; };
			m_images[i].src = images[i];
		}
	}

	var pub_setURLs = function(urls)
	{
		m_urls = urls;
	}

	var pub_setCanvas = function(canvas)
	{
		m_context = canvas.getContext("2d");
		m_size 	= [canvas.width, canvas.height];

		canvas.onclick = function()
		{
			if(m_urls && m_urls[m_index])
				window.location = m_urls[m_index];
		}
	}

	var pub_setInterval = function(interval)
	{
		m_interval = interval;
	}

	var pub_setFGColor = function(color)
	{
		m_colorFG = color;
	}

	var pub_setBGColor = function(color)
	{
		m_colorBG = color;
	}

	var pub_setShowBar = function(b)
	{
		m_showBar = b === true;
	}

	var pub_setBarType = function(type)
	{
		m_barType = type;
	}

	var pub_setInterval = function(interval)
	{
		m_interval = interval;
	}

	var pub_start = function()
	{
		m_isActive = true;
		requestAnimationFrame(pri_drawLoop);
	}

	var pub_stop = function()
	{
		m_isActive = false;
	} 

	var pri_drawLoop = function(now)
	{
		m_counter += (now - m_lastTime);
		m_lastTime = now;
		var progress = Math.min(1, m_counter / m_interval);

		if(m_counter > m_interval)
		{
			m_counter = 0;
			m_index++;
			m_isDrawn = false;

			if(m_index >= m_imgCount)
				m_index = 0;
		}

		if(m_images && m_imgCount == m_loaded)
		{
			var ctx = m_context;

			if(!m_isDrawn)
			{
				var img = m_images[m_index];
				ctx.clearRect(0, 0, m_size[0], m_size[1]);
				ctx.drawImage(img, 0, 0, m_size[0], m_size[1] - (m_showBar ? 4 : 0));
				m_isDrawn = true;
			}

			if(m_showBar)
			{
				ctx.fillStyle = m_colorBG;
				ctx.fillRect(0, m_size[1] - 4, m_size[0], 4);

				ctx.fillStyle = m_colorFG;
				if(m_barType === 0)
				{
					ctx.fillRect(1, m_size[1] - 3, (m_size[0] - 2) * progress, 2);
				}
				else if(m_barType === 1)
				{
					ctx.fillRect((m_size[0] - 12) * progress, m_size[1] - 3, 10, 2);
				}
				else if(m_barType === 2)
				{
					var width = (m_size[0] - 2) * progress;
					ctx.fillRect((m_size[0] * 0.5) - width * 0.5, m_size[1] - 3, width, 2);
				}
			}
		}

		if(m_isActive)
			requestAnimationFrame(pri_drawLoop);
	}

	return {
		SetImages 	: pub_setImages,
		SetURLs 	: pub_setURLs,
		SetCanvas 	: pub_setCanvas,
		SetInterval : pub_setInterval,
		SetFGColor 	: pub_setFGColor,
		SetBGColor 	: pub_setBGColor,
		SetShowBar 	: pub_setShowBar,
		SetBarType 	: pub_setBarType,
		Start 		: pub_start,
		Stop 		: pub_stop
	};
}
