<?php
// ============================================================
//  A.S.H. Finiture Contract — Di Ahmed Abdelaziz
//  Dati condivisi: azienda + servizi + realizzazioni
//  Incluso da: realizzazioni.php e dettaglio-realizzazione.php
//  (entrambe pagine nella root, quindi i percorsi sono relativi alla root)
// ============================================================

// ---- Dati azienda / contatti ----
$site_name  = 'A.S.H. Finiture Contract';
$tagline    = 'Qualità e Precisione per Ogni Spazio';
$phone1     = '329 6447797';
$phone2     = '338 3386946';
$phone1_raw = '+393296447797';
$phone2_raw = '+393383386946';
$email      = 'ashfiniturecontract@outlook.it';
$address    = 'Via Adigrat 3/A, 62032 Camerino (MC)';

// ---- Tutti i servizi (per menu + filtri + badge) ----
$servizi = [
    [
        'slug'   => 'cartongesso',
        'icona'  => 'bi-bricks',
        'titolo' => 'Cartongesso',
        'url'    => 'servizi/cartongesso.php',
    ],
    [
        'slug'   => 'sistemi-a-secco',
        'icona'  => 'bi-layers',
        'titolo' => 'Sistemi a Secco',
        'url'    => 'servizi/sistemi-a-secco.php',
    ],
    [
        'slug'   => 'rasatura-armata',
        'icona'  => 'bi-shield-check',
        'titolo' => 'Rasatura Armata',
        'url'    => 'servizi/rasatura-armata.php',
    ],
    [
        'slug'   => 'tinteggiatura',
        'icona'  => 'bi-paint-bucket',
        'titolo' => 'Tinteggiatura',
        'url'    => 'servizi/tinteggiatura.php',
    ],
    [
        'slug'   => 'intonachino',
        'icona'  => 'bi-brush',
        'titolo' => 'Intonachino',
        'url'    => 'servizi/intonachino.php',
    ],
    [
        'slug'   => 'carta-da-parati',
        'icona'  => 'bi-flower1',
        'titolo' => 'Carta da Parati',
        'url'    => 'servizi/carta-da-parati.php',
    ],
];

// Indice rapido: slug => servizio (per badge e link delle card)
$servizi_per_slug = array_column($servizi, null, 'slug');

// ---- Le realizzazioni ----
// Ogni progetto ha un 'id' univoco usato dalla pagina di dettaglio
// (dettaglio-realizzazione.php?id=...). 'foto' è la copertina della card;
// 'copertina' è l'immagine grande nella pagina di dettaglio;
// 'galleria' sono le foto della gallery.
$realizzazioni = [
    [
        'id'          => 1,
        'categoria'   => 'cartongesso',
        'titolo'      => 'Controsoffitto con luci LED integrate',
        'sottotitolo' => 'Ribassamento in cartongesso con gole luminose e faretti: la zona giorno cambia volto.',
        'luogo'       => 'Camerino (MC)',
        'anno'        => '2025',
        'durata'      => '3 giorni',
        'tipologia'   => 'Abitazione privata',
        'superficie'  => 'Zona giorno ~32 m²',
        'foto'        => 'assets/img/servizi/cartongesso-stuccatura.jpg',
        'copertina'   => 'assets/img/servizi/cartongesso-controsoffitti.jpg',
        'sfida'       => 'Il soggiorno aveva un soffitto piatto e una luce fredda e uniforme. L\'obiettivo era dare profondità all\'ambiente e creare una luce d\'atmosfera, senza opere murarie invasive.',
        'descrizione' => [
            'Abbiamo progettato un controsoffitto ribassato su misura, con una gola perimetrale che nasconde una striscia LED a luce calda e una serie di faretti orientabili per l\'illuminazione funzionale. Il disegno del ribassamento segue le proporzioni della stanza e valorizza la zona living.',
            'La struttura è stata realizzata con orditura metallica e lastre di cartongesso, stuccata a livello Q4 nei punti a vista per una superficie perfettamente liscia, pronta per la tinteggiatura. Il risultato è un ambiente più caldo, moderno e accogliente.',
        ],
        'interventi'  => [
            'Progettazione del ribassamento su misura',
            'Orditura metallica e posa delle lastre',
            'Gola luminosa perimetrale per striscia LED',
            'Predisposizione impianto per faretti orientabili',
            'Stuccatura Q4 delle superfici a vista',
            'Preparazione alla tinteggiatura',
        ],
        'galleria'    => [
            'assets/img/servizi/cartongesso-controsoffitti.jpg',
            'assets/img/servizi/cartongesso-abitazioni.jpg',
            'assets/img/servizi/cartongesso-contropareti.jpg',
            'assets/img/servizi/cartongesso-arredi.jpg',
            'assets/img/servizi/cartongesso-uffici.jpg',
            'assets/img/servizi/cartongesso-stuccatura.jpg',
        ],
    ],
    [
        'id'          => 2,
        'categoria'   => 'sistemi-a-secco',
        'titolo'      => 'Pareti divisorie per nuovi uffici',
        'sottotitolo' => 'Riorganizzazione degli spazi con pareti a secco e isolamento acustico, senza opere murarie.',
        'luogo'       => 'Macerata',
        'anno'        => '2025',
        'durata'      => '1 settimana',
        'tipologia'   => 'Uffici direzionali',
        'superficie'  => 'Open space ~120 m²',
        'foto'        => 'assets/img/servizi/card-sistemi-a-secco.jpg',
        'copertina'   => 'assets/img/servizi/card-sistemi-a-secco.jpg',
        'sfida'       => 'Un open space unico da suddividere in più uffici operativi e una sala riunioni, mantenendo la riservatezza acustica e riducendo al minimo i tempi di cantiere per non fermare l\'attività.',
        'descrizione' => [
            'Abbiamo suddiviso l\'open space con pareti in sistema a secco a doppia lastra e lana minerale nell\'intercapedine, ottenendo un buon isolamento acustico tra gli ambienti. Le nuove pareti integrano le predisposizioni per gli impianti elettrici e dati, senza tracce né demolizioni.',
            'Il montaggio a secco ci ha permesso di lavorare in modo pulito e rapido, con tempi certi e nessuna attesa per l\'asciugatura. Gli uffici sono stati consegnati pronti per la tinteggiatura e l\'arredo.',
        ],
        'interventi'  => [
            'Rilievo e tracciamento dei nuovi ambienti',
            'Pareti a secco a doppia lastra con lana minerale',
            'Isolamento acustico tra gli uffici',
            'Predisposizione impianti elettrici e dati',
            'Stuccatura e preparazione alle finiture',
        ],
        'galleria'    => [
            'assets/img/servizi/card-sistemi-a-secco.jpg',
            'assets/img/servizi/spazio-uffici.jpg',
            'assets/img/servizi/cartongesso-uffici.jpg',
            'assets/img/servizi/cartongesso-contropareti.jpg',
            'assets/img/servizi/cartongesso-commerciali.jpg',
        ],
    ],
    [
        'id'          => 3,
        'categoria'   => 'rasatura-armata',
        'titolo'      => 'Rasatura armata su cappotto termico',
        'sottotitolo' => 'Superficie rinforzata con rete e finitura uniforme: facciata protetta e pronta alla tinteggiatura.',
        'luogo'       => 'Tolentino (MC)',
        'anno'        => '2024',
        'durata'      => '3 settimane',
        'tipologia'   => 'Condominio',
        'superficie'  => 'Facciate ~420 m²',
        'foto'        => 'assets/img/servizi/card-rasatura-armata.jpg',
        'copertina'   => 'assets/img/servizi/card-rasatura-armata.jpg',
        'sfida'       => 'Dopo la posa del cappotto termico, la facciata del condominio doveva essere protetta e resa perfettamente planare, con una base solida e anticrepa pronta a ricevere la finitura colorata.',
        'descrizione' => [
            'Abbiamo applicato la rasatura armata annegando la rete in fibra di vetro in un doppio strato di rasante, così da distribuire le tensioni ed evitare la formazione di crepe. La superficie è stata poi lisciata e resa uniforme su tutta l\'estensione delle facciate.',
            'Questa lavorazione protegge il sistema a cappotto dagli agenti atmosferici e garantisce una base durevole e regolare. Una volta asciutta, la facciata era pronta per l\'applicazione dell\'intonachino di finitura.',
        ],
        'interventi'  => [
            'Preparazione e controllo del supporto (cappotto)',
            'Applicazione del primo strato di rasante',
            'Annegamento della rete in fibra di vetro',
            'Secondo strato e lisciatura della superficie',
            'Rasatura degli spigoli con paraspigoli',
            'Preparazione alla finitura colorata',
        ],
        'galleria'    => [
            'assets/img/servizi/card-rasatura-armata.jpg',
            'assets/img/servizi/spazio-facciate.jpg',
            'assets/img/servizi/spazio-condomini.jpg',
            'assets/img/servizi/cartongesso-stuccatura.jpg',
        ],
    ],
    [
        'id'          => 4,
        'categoria'   => 'tinteggiatura',
        'titolo'      => 'Tinteggiatura completa di villa bifamiliare',
        'sottotitolo' => 'Ciclo completo interni ed esterni con prodotti certificati: colori uniformi e durevoli.',
        'luogo'       => 'Camerino (MC)',
        'anno'        => '2025',
        'durata'      => '2 settimane',
        'tipologia'   => 'Abitazione privata',
        'superficie'  => 'Interni ed esterni',
        'foto'        => 'assets/img/servizi/tinteggiatura-ciclo.jpg',
        'copertina'   => 'assets/img/servizi/tinteggiatura-ciclo.jpg',
        'sfida'       => 'Rinnovare completamente una villa bifamiliare, dentro e fuori, con colori caldi e uniformi e una resa impeccabile anche in controluce, proteggendo mobili e pavimenti durante i lavori.',
        'descrizione' => [
            'Abbiamo eseguito il ciclo completo: preparazione dei fondi, stuccatura delle imperfezioni, applicazione del fissativo e doppia mano di pittura. Per gli interni abbiamo scelto una pittura traspirante e lavabile, per gli esterni un prodotto resistente agli agenti atmosferici.',
            'La protezione accurata di pavimenti, infissi e arredi ha permesso di lavorare in modo ordinato e pulito. Il risultato è una casa dal colore uniforme, luminosa e curata in ogni dettaglio.',
        ],
        'interventi'  => [
            'Protezione di pavimenti, infissi e arredi',
            'Preparazione dei fondi e stuccatura',
            'Applicazione del fissativo',
            'Doppia mano di pittura traspirante agli interni',
            'Pittura per esterni resistente agli agenti atmosferici',
            'Ritocchi e pulizia finale del cantiere',
        ],
        'galleria'    => [
            'assets/img/servizi/tinteggiatura-ciclo.jpg',
            'assets/img/servizi/spazio-abitazioni.jpg',
            'assets/img/servizi/spazio-facciate.jpg',
            'assets/img/servizi/spazio-bagni-cucine.jpg',
            'assets/img/servizi/spazio-condomini.jpg',
        ],
    ],
    [
        'id'          => 5,
        'categoria'   => 'intonachino',
        'titolo'      => 'Intonachino decorativo per la zona giorno',
        'sottotitolo' => 'Finitura materica a effetto naturale: carattere ed eleganza per le pareti del soggiorno.',
        'luogo'       => 'San Severino Marche (MC)',
        'anno'        => '2024',
        'durata'      => '4 giorni',
        'tipologia'   => 'Abitazione privata',
        'superficie'  => 'Zona giorno ~40 m²',
        'foto'        => 'assets/img/servizi/card-intonachino.jpg',
        'copertina'   => 'assets/img/servizi/card-intonachino.jpg',
        'sfida'       => 'Dare personalità e calore alla parete principale del soggiorno con una finitura materica, evitando l\'effetto piatto della pittura tradizionale.',
        'descrizione' => [
            'Abbiamo preparato il fondo con rasatura e fissativo, quindi applicato l\'intonachino a più mani, lavorandolo con la spatola per creare un effetto materico dai movimenti morbidi e naturali. La tonalità è stata scelta insieme al cliente su campionatura.',
            'La finitura, oltre a essere esteticamente ricca, è resistente e facile da mantenere nel tempo. La parete è diventata il vero elemento d\'arredo della zona giorno.',
        ],
        'interventi'  => [
            'Rasatura e preparazione del fondo',
            'Applicazione del fissativo colorato',
            'Stesura dell\'intonachino a più mani',
            'Lavorazione materica con la spatola',
            'Protezione finale della superficie',
        ],
        'galleria'    => [
            'assets/img/servizi/card-intonachino.jpg',
            'assets/img/servizi/spazio-abitazioni.jpg',
            'assets/img/servizi/spazio-negozi.jpg',
            'assets/img/servizi/spazio-facciate.jpg',
        ],
    ],
    [
        'id'          => 6,
        'categoria'   => 'carta-da-parati',
        'titolo'      => 'Carta da parati di design in camera',
        'sottotitolo' => 'Posa di precisione per una parete d\'accento: giunzioni invisibili e risultato scenografico.',
        'luogo'       => 'Matelica (MC)',
        'anno'        => '2025',
        'durata'      => '2 giorni',
        'tipologia'   => 'Abitazione privata',
        'superficie'  => 'Parete d\'accento ~14 m²',
        'foto'        => 'assets/img/servizi/card-carta-da-parati.jpg',
        'copertina'   => 'assets/img/servizi/card-carta-da-parati.jpg',
        'sfida'       => 'Trasformare la parete dietro il letto in un elemento scenografico con una carta da parati a motivo grande, dove ogni giunzione doveva risultare invisibile e il disegno perfettamente allineato.',
        'descrizione' => [
            'Abbiamo preparato la parete con rasatura e fondo specifico per garantire un\'adesione uniforme. La posa è stata eseguita con la massima cura nell\'allineamento del disegno e nella corrispondenza dei teli, per giunzioni impercettibili.',
            'Attorno a prese, interruttori e battiscopa il taglio è stato rifinito a regola d\'arte. Il risultato è una camera dal forte carattere, con una parete d\'accento di grande effetto.',
        ],
        'interventi'  => [
            'Preparazione e rasatura della parete',
            'Applicazione del fondo per carta da parati',
            'Calcolo e taglio dei teli sul disegno',
            'Posa con allineamento e corrispondenza dei motivi',
            'Rifinitura attorno a prese e battiscopa',
        ],
        'galleria'    => [
            'assets/img/servizi/card-carta-da-parati.jpg',
            'assets/img/servizi/spazio-abitazioni.jpg',
            'assets/img/servizi/spazio-bagni-cucine.jpg',
        ],
    ],
];

// Indice rapido: id => realizzazione (per la pagina di dettaglio)
$realizzazioni_per_id = array_column($realizzazioni, null, 'id');
