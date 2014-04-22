Logic = 0
Render = 1

function CreateTransform(e, p, s, r)
{
	var m_entity 	= e;
	var m_position 	= p ? p : [0, 0];
	var m_scale 	= s ? s : [0, 0];
	var m_rotation 	= r ? r : [0, 0];

	var Update = function()
	{
		//console.log("Transform.Update");
	}

	return {
		Id 			: "Transform",
		Type 		: Logic,
		Entity  	: m_entity,
		Position 	: m_position,
		Scale 		: m_scale,
		Rotation 	: m_rotation,

		Update : Update
	};
}

function CreateRender(e)
{
	var m_entity = e;

	var Update = function()
	{
		var position = m_entity.Components.Transform.Position;
		var scale = m_entity.Components.Transform.Scale;
		var ctx = m_entity.Game.Context;
		
		ctx.fillStyle = "#F00";
		ctx.fillRect(position[0], position[1], scale[0], scale[1]);
	}

	return {
		Id 		: "Render",
		Type 	: Render,
		Entity 	: m_entity,

		Update 	: Update
	};
}

function CreateMovement(e, s)
{
	var m_entity = e;
	var m_speed = s;

	var Update = function()
	{
		var position = m_entity.Components.Transform.Position;
		var input = m_entity.Game.Controls;
		var delta = m_entity.Game.GetDelta();

		if(input.Up.State === true)
			position[1] -= m_speed * delta;

		if(input.Down.State === true)
			position[1] += m_speed * delta;

		if(input.Left.State === true)
			position[0] -= m_speed * delta;

		if(input.Right.State === true)
			position[0] += m_speed * delta;
	}

	return {
		Id 		: "Test",
		Type 	: Logic,
		Entity 	: m_entity,

		Update : Update
	};
}

console.log("loaded: component.js");