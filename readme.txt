Tietokannat, WWW-Palvelinohjelmointi ja WWW-Tekniikat kurssien yhdistetty harjoitustyö.

Ryhmä: Mika Muhonen, Iiro Surakka
Aihe: Verkkokauppa (Yksinkertainen, geneerinen)
Toteutus kieli: PHP
Muut tekniikat: HTML, CSS, JavaScript​, jQuery
Tietokanta: MySQL
Alustava tietokantamalli:
	​Product (id, name, brand, model, description, category, quantity, price, discount)
	User (id, username, hash, salt, type [customer, employee, admin])
	Order (id, userId, date, message, status, *address ...*)
	OrderProduct (id, orderId, productId, quantity)

Yleiskuvaus:
	Kaikki pystyy ...
		selaamaan kaupan tuotteita
		​kirjautumaan/rekisteröitymään sivustolle​
		ostamaan kaikkia selaamalla löytyviä tuotteita​

	Asiakas pystyy lisäksi ...
		muokkaamaan omia käyttäjä tietojaan

	Työntekijä pystyy lisäksi ...
		muokkaamaan tuotteiden ja tilausten tietoja

	Ylläpito pystyy lisäksi ...
		muokkaamaan kaikkien käyttäjien tietoja
