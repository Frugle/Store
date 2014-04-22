
function CreateEntity()
{
	var m_game = null;
	var m_components = [];

	var Add = function(c)
	{
		for(var i in c)
		{
			c[i].Entity = this;
			m_components[c[i].Id] = c[i];
		}
		m_components.sort(function(a, b) { return a.Id - b.Id; });
	};

	var Update = function()
	{
		for(var i in m_components)
			m_components[i].Update();
	};

	return {
		Game : m_game,
		Components : m_components,

		Add : Add,
		Update : Update
	};
}

function CreatePlayer()
{
	var e = CreateEntity();
	e.Add(
	[
		CreateTransform(e, [100, 100], [10, 10]),
		CreateMovement(e, 300.0),
		CreateRender(e)
	]);

	return e;
}

console.log("loaded: player.js");