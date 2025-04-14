# 🧠 ESERCIZIO DI PROGETTAZIONE IN AUTONOMIA

## 🎯 Obiettivo
Progettare un **modello concettuale (ERM)** per una piattaforma ispirata a uno dei seguenti scenari.  
Il modello deve rappresentare entità, attributi principali e relazioni con cardinalità corrette.  
Utilizza **MySQL Workbench** per disegnare lo schema.

---

## 🧩 Scegli uno scenario tra i seguenti:

### 1️⃣ **Biblioteca Digitale**
Una piattaforma per la gestione di una biblioteca:
- `Libro`, `Categoria`, `Lettore`, `Prestito`, `Prenotazione`, `Utente`
- Possibili concetti: disponibilità, prenotazioni, più copie, data prestito

---

### 2️⃣ **Corsi Online (stile Udemy)**
Una piattaforma per seguire corsi online:
- `Corso`, `Studente`, `Docente`, `Lezione`, `Iscrizione`, `Valutazione`
- Concetti: progressi nei corsi, corsi multi-docente, feedback

---

### 3️⃣ **Palestra / Centro sportivo**
Una gestione digitale di palestra o centro benessere:
- `Cliente`, `Abbonamento`, `Istruttore`, `Lezione`, `Prenotazione`
- Concetti: fasce orarie, prenotazioni con limite posti, scadenza abbonamento

---

### 4️⃣ **Food Delivery (tipo JustEat)**
Una piattaforma per ordinare cibo online:
- `Cliente`, `Ristorante`, `Piatto`, `Ordine`, `Pagamento`, `Corriere`
- Concetti: ordine con più piatti, categorie, tracking consegna

---

### 5️⃣ **Conferenza / Evento con sessioni**
Un gestionale per conferenze con speaker e iscritti:
- `Partecipante`, `Evento`, `Sessione`, `Relatore`, `Registrazione`
- Concetti: eventi paralleli, iscrizione a sessioni, multitraccia

---

## 🛠️ Cosa devi fare

1. Scegli uno dei 5 scenari.
2. Progetta il **diagramma ERM** con le entità, relazioni e attributi chiave.
3. Inserisci le cardinalità corrette (1:1, 1:N, N:M).
4. Aggiungi eventuali entità intermedie dove necessario.
5. Salva il file `.mwb`.

---

## 📦 Consegna
Crea un repository github per l'esercizio, e linkalo ad un messaggio nel forum.  
(Opzionale) aggiungi anche un breve commento descrivendo le scelte progettuali, nel file `README.MD` del progetto.

---

## ✨ Bonus (facoltativo)
Se finisci in anticipo, prova ad aggiungere:
- Entità avanzate come `Recensione`, `Pagamento`, `Dispositivo`, `Tracciamento`
- Attributi temporali (es. `data_inizio`, `data_fine`, `ultima_modifica`)
- Vincoli di unicità o regole speciali

---

## ❗ Importante
**Nessun codice SQL da scrivere** in questa fase.  
Focus sulla **modellazione concettuale** e uso di **MySQL Workbench**.

Buon lavoro 💪🏻
