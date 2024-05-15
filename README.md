# cms_camping
CMS system for a camping.
Repistory for a camping website that is written in JS, PHP and uses SQL as their database.
File structure will be

- /admin
- /css
- /js
- /includes'
  - /languages
  - header.php
  - footer.php
  - logout.php
  - db.php
- login.php



Requirements:

usecase
Naam	Reserveringssysteem Camping La Rustique 
Samenvatting	De medewerker voert de benodigde informatie in om een nieuwe campingplaats te registreren in het systeem.
Actor	Medewerker/Manager
Pre-conditie	De medewerker is ingelogd in het systeem en heeft toegang tot de registratiemodule.
Main-succes-scenario	"De medewerker navigeert naar de registratiemodule.
De medewerker voert de benodigde informatie in, zoals locatie, en beschikbaarheid van de campingplaats.
Het systeem valideert de ingevoerde informatie en registreert de campingplaats in de database.
"
Uitzonderingen	Als de ingevoerde informatie onvolledig of incorrect is, wordt de medewerker gevraagd om de juiste gegevens in te voeren.
Postconditie	De nieuwe campingplaats is succesvol geregistreerd in het systeem.

<img width="457" alt="image" src="https://github.com/RonanTalboom/cms_camping/assets/8617184/fc93dd4a-6909-4717-8cec-ac14bb25a381">



Functies
- Inlogfunctie voor medewerkers en leidinggevenden 
- Medewerkers/leidinggevenden invoeren 
- Medewerkers/leidinggevenden wijzigen 
- Medewerkers/leidinggevenden verwijderen 
- Medewerkers/leidinggevenden overzicht  Klantgegevens invoeren 
- Klantopties invoeren 
- Reserveringsgegevens invoeren (denk aan campingplaats, datum aankomst/vertrek) 
- Reserveringsoverzicht (je kunt onderscheid maken tussen open en gesloten reserveringen) 
- Voorkomen van dubbele reserveringen 
- Reservering wijzigen  
- Reservering verwijderen 
- Overzicht van campingplaatsen* 
- Overzicht van tarieven* 
- Afdrukken factuur klant  
- Overzicht van alle inkomsten uit de reserveringen (alleen zichtbaar voor leidinggevenden)   

*optioneel is een pagina van campingplaatsen en of tarieven.

Programma van eisen (MoSCoW)  Must have:
1. Het systeem moet duidelijk aangeven wanneer een plaats bezet is.
2. Bij het verlaten van de camping wordt de plek automatisch vrijgegeven en kan er een factuur worden afgedrukt.
3. Het systeem moet de checkin en checkout datum en tijd weergeven bij het reserveren van een campingplaats.
4. Prijsindicatie moet beschikbaar zijn voor verschillende soorten plaatsen.

should have:
1. Kleurenschema voorkeur: vrolijke en rustieke tinten zoals groen en geel.
2. Het systeem moet medewerkers in staat stellen om plaatsen te beheren en toe te voegen. Verwijderen mogen alleen managers.
3. Inloggen in het systeem moet vereist zijn voordat opties worden weergegeven.
4. Bezette plaatsen moeten duidelijk gemarkeerd zijn of een andere kleur hebben.
5. Mogelijkheid om dagtarieven op een aparte pagina weer te geven en op te slaan in de database.
6. Het systeem moet in het Nederlands zijn.

Could have:
1. Verbeterde gebruikersinterface voor een aantrekkelijker ontwerp.
2. Mogelijkheid om reserveringen te beheren via een mobiele app.
3. Flexibiliteit in reserveringsmethoden: reserveren via plattegrond, tabel of andere overzichten.









Dagtarieven Camping La Rustique 
Volwassene 	5 euro
Kinderen van 4 tot 12 jaar 	4 euro
Kinderen tot 4 jaar 	Gratis
Hond (maximaal 1 huisdier per campingplaats)	2 euro
Elektriciteit 	2 euro
Bezoekers	2 euro
Douche (munten verkrijgbaar bij de receptie)	0,50 euro
Wasmachine 	6 euro
Wasdroger	4 euro
Caravan of camper (kleine plaats) 	2 euro
Caravan of camper (grote plaats)	4 euro
Tent (kleine plaats)	3 euro
Tent (grote plaats)	5 euro
Auto	3 euro

<img width="457" alt="image" src="https://github.com/RonanTalboom/cms_camping/assets/8617184/2a40fdc1-6027-4a1d-a9c4-5ab49be553b7">



Disclaimer
Camping La Rustique is een fictief bedrijf bedoeld voor educatieve doeleinden. Genoemde namen zijn tevens fictief. Overeenkomsten met bestaande bedrijven en personen berusten op louter toeval.
