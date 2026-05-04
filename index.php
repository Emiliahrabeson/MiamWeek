<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miam</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    
<div class="app">
  <div class="topbar">
    <div class="brand">
      <div class="brand-icon">&#9963;</div>
      <span class="brand-name">MiamWeek</span>
    </div>
    <div class="topbar-right">
      <button class="notif">&#128276;<div class="notif-dot"></div></button>
      <div class="avatar">RA</div>
    </div>
  </div>

  <div class="main">
    <div class="sidebar">
      <div class="nav-section">
        <div class="nav-label">Principal</div>
        <div class="nav-item active"> Tableau de bord</div>
        <div class="nav-item"> Calendrier</div>
        <div class="nav-item"> Historique</div>
      </div>
      <div class="nav-section">
        <div class="nav-label">Repas</div>
        <div class="nav-item"> Recettes</div>
        <div class="nav-item"> Liste de courses <span class="badge">3</span></div>
        <div class="nav-item"> Favoris <span class="badge">7</span></div>
      </div>
      <div class="nav-section">
        <div class="nav-label">Santé</div>
        <div class="nav-item"> Calories</div>
        <div class="nav-item"> Bien-être</div>
        <div class="nav-item"> Recherche</div>
      </div>
    </div>

    <div class="content">
      <div class="greeting">Bonjour, <em>Ravo</em> !</div>
      <div class="greeting-sub">Lundi 5 mai  3 repas planifiés aujourd'hui</div>

      <div class="wellness">
        <div class="wi"> Température : <strong>37.2°C</strong></div>
        <div class="wsep"></div>
        <div class="wi"> Humeur : <strong>Bien</strong></div>
        <div class="wsep"></div>
        <div class="wi alert"> Allergie : <strong>Lactose</strong></div>
        <div class="wsep"></div>
        <div class="wi" style="margin-left:auto;"><strong style="color:#C4773A;">Objectif : 1 800 kcal/j</strong></div>
      </div>

      <div class="stats">
        <div class="stat">
          <div class="stat-lbl">Calories aujourd'hui</div>
          <div class="stat-val">1 240</div>
          <div class="stat-sub">sur 1 800 kcal</div>
          <div class="bar-bg"><div class="bar-fg" style="width:69%;"></div></div>
        </div>
        <div class="stat">
          <div class="stat-lbl">Repas planifiés</div>
          <div class="stat-val">3 / 3</div>
          <div class="stat-sub">+collation possible</div>
          <div class="bar-bg"><div class="bar-fg" style="width:100%;"></div></div>
        </div>
        <div class="stat">
          <div class="stat-lbl">Ingrédients dispo</div>
          <div class="stat-val">12</div>
          <div class="stat-sub">4 recettes possibles</div>
          <div class="bar-bg"><div class="bar-fg" style="width:55%;"></div></div>
        </div>
        <div class="stat">
          <div class="stat-lbl">Streak actif</div>
          <div class="stat-val">6 j</div>
          <div class="stat-sub">meilleur : 14 jours</div>
          <div class="bar-bg"><div class="bar-fg" style="width:43%;"></div></div>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head">
          <span class="panel-title">Semaine du 5 au 11 mai</span>
          <span class="panel-link">Générer plan</span>
        </div>
        <div class="week">
          <div class="day"><div class="day-name">Lun</div><div class="day-num today">5</div><div class="day-meal">Salade niçoise</div><div class="day-kcal">520 kcal</div></div>
          <div class="day"><div class="day-name">Mar</div><div class="day-num">6</div><div class="day-meal">Riz sauté</div><div class="day-kcal">480 kcal</div></div>
          <div class="day"><div class="day-name">Mer</div><div class="day-num">7</div><div class="day-meal">Soupe légumes</div><div class="day-kcal">310 kcal</div></div>
          <div class="day"><div class="day-name">Jeu</div><div class="day-num">8</div><div class="day-meal">Pasta tomate</div><div class="day-kcal">560 kcal</div></div>
          <div class="day"><div class="day-name">Ven</div><div class="day-num">9</div><div class="day-meal">Poulet grillé</div><div class="day-kcal">490 kcal</div></div>
          <div class="day"><div class="day-name">Sam</div><div class="day-num">10</div><div class="day-meal" style="color:#B8A090;">Non planifié</div></div>
          <div class="day"><div class="day-name">Dim</div><div class="day-num">11</div><div class="day-meal" style="color:#B8A090;">Non planifié</div></div>
        </div>
      </div>

      <div class="two">
        <div class="panel" style="margin-bottom:0;">
          <div class="panel-head"><span class="panel-title">Repas du jour</span><span class="panel-link">Voir tout</span></div>
          <div class="meals">
            <div class="meal-row">
              <div><div class="meal-name">Petit-déjeuner</div><div class="meal-meta">Porridge aux fruits · 08h00</div></div>
              <div class="meal-kcal">380 kcal</div>
            </div>
            <div class="meal-row">
              <div><div class="meal-name">Déjeuner</div><div class="meal-meta">Salade niçoise · 12h30</div></div>
              <div class="meal-kcal">520 kcal</div>
            </div>
            <div class="meal-row">
              <div><div class="meal-name">Dîner</div><div class="meal-meta">Riz sauté légumes · 19h00</div></div>
              <div class="meal-kcal">340 kcal</div>
            </div>
          </div>
        </div>

        <div class="panel" style="margin-bottom:0;">
          <div class="panel-head"><span class="panel-title">Calories / 7 jours</span></div>
          <div class="cal-bars">
            <div class="cal-row"><div class="cal-day">Lun</div><div class="cal-track"><div class="cal-fill" style="width:70%;"></div></div><div class="cal-num">1 680 kcal</div></div>
            <div class="cal-row"><div class="cal-day">Mar</div><div class="cal-track"><div class="cal-fill" style="width:80%;"></div></div><div class="cal-num">1 920 kcal</div></div>
            <div class="cal-row"><div class="cal-day">Mer</div><div class="cal-track"><div class="cal-fill" style="width:60%;"></div></div><div class="cal-num">1 450 kcal</div></div>
            <div class="cal-row"><div class="cal-day">Jeu</div><div class="cal-track"><div class="cal-fill" style="width:74%;"></div></div><div class="cal-num">1 780 kcal</div></div>
            <div class="cal-row"><div class="cal-day">Ven</div><div class="cal-track"><div class="cal-fill" style="width:67%;"></div></div><div class="cal-num">1 600 kcal</div></div>
            <div class="cal-row"><div class="cal-day">Sam</div><div class="cal-track"><div class="cal-fill" style="width:88%;background:#A0612E;"></div></div><div class="cal-num">2 100 kcal</div></div>
            <div class="cal-row"><div class="cal-day">Auj</div><div class="cal-track"><div class="cal-fill" style="width:52%;"></div></div><div class="cal-num">1 240 kcal</div></div>
          </div>
        </div>
      </div>

      <div class="panel" style="margin-top:12px;margin-bottom:0;">
        <div class="panel-head"><span class="panel-title">Recommandé pour toi</span><span class="panel-link">Plus de suggestions</span></div>
        <div class="recos">
          <div class="reco"><div class="reco-img">&#127807;</div><div class="reco-name">Buddha bowl quinoa</div><div class="tags"><span class="tag">Végétarien</span><span class="tag">25 min</span></div></div>
          <div class="reco"><div class="reco-img">&#127858;</div><div class="reco-name">Curry lentilles corail</div><div class="tags"><span class="tag w">Budget ↓</span><span class="tag">30 min</span></div></div>
          <div class="reco"><div class="reco-img">&#127828;</div><div class="reco-name">Wrap poulet avocat</div><div class="tags"><span class="tag">Protéines</span><span class="tag">15 min</span></div></div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
