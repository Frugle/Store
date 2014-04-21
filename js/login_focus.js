
function FocusDefault(elementId, value)
{
	var m_element = document.getElementById(elementId);
	var m_value = value;

	m_element.value = m_value;

	m_element.onfocus = function()
	{
		if(!m_element.value || m_element.value === m_value)
			m_element.value = "";
	};

	m_element.onblur = function()
	{
		if(!m_element.value)
			m_element.value = m_value;
	}
}
