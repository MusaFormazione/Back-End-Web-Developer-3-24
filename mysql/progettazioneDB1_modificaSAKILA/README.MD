# Progetto: Videoteca Online – Modellazione ERM

## 🎯 Obiettivo
Progettare il **modello concettuale** (Entity-Relationship Model) di una piattaforma per la gestione di una videoteca online, ispirata a sistemi come Netflix o Prime Video (in versione semplificata).

---

## 🧱 Requisiti di base

Il sistema deve gestire:

- Utenti registrati che possono accedere alla piattaforma
- Sistema di abbonamenti con rinnovo periodico
- Visualizzazione dei film da parte degli utenti

---

## 📄 Entità suggerite

| Entità | Descrizione                                             |
|--------|---------------------------------------------------------|
| `Customer` | Informazioni anagrafiche (nome, email, indirizzo, ecc.) |
| `Utente` | Account di accesso con `username` e `password`          |
| `Film` | Titolo, anno, durata, ecc.                              |
| `Categoria` | Nome categoria (dramma, horror, ecc.)                   |
| `Visualizzazione` | Traccia quando un utente ha visto un film               |
| `Subscription` | Tipi di abbonamento disponibili (mensile, annuale...)   |
| `UserSubscription` | Lega un utente a un abbonamento attivo                  |
| `Pagamento` | Riferito a un abbonamento attivo                        |

---

## 🔄 Relazioni principali

- `Customer` 1 — 1/N `Utente` → decidere se ogni cliente ha uno o più account
- `Utente` N — N `Film` tramite `Visualizzazione`
- `Film` N — 1 `Categoria`
- `User` 1 — 1 `UserSubscription`
- `UserSubscription` 1 — N `Pagamento`
- `UserSubscription` N — 1 `Subscription`

---

## 💡 Punti di riflessione progettuale

- Ogni utente ha un solo account 1:1 o può esistere una gestione multi-profilo 1:N?
- Vogliamo registrare ogni visualizzazione con data e durata?
- Ogni film ha una sola categoria o può appartenere a più categorie?
- Come collegheremmo un file video al database (es. tabella `ContenutoMultimediale` con campo blob o path)?

---

## 🧠 Consegnabile

- Diagramma ERM disegnato con **MySQL Workbench**
- Mostrare entità, attributi principali, chiavi primarie
- Relazioni con cardinalità (1:1, 1:N, N:M)
- Eventuali entità intermedie come `Visualizzazione` o `UserSubscription`

---

## ⚙️ Strumenti consigliati

Utilizzeremo **MySQL Workbench** per disegnare graficamente il modello ER.  
👉 **Non scriveremo ancora codice SQL (DDL)**: ci concentreremo sulla progettazione logica e visuale.

---

## ✍️ Modalità di lavoro

- Lavoro individuale o a coppie
- Tempo stimato: **45-60 minuti**
- Alla fine: presentazione volontaria e confronto tra modelli

---

## ✅ Bonus (per chi finisce prima)

- Aggiungere la gestione delle **recensioni degli utenti** (`Recensione`: utente, film, testo, voto)
- Collegare i film a file video reali (campo `path` o `blob`)
- Gestione dei dispositivi da cui l’utente guarda (telefono, tablet, TV, ecc.)

---

## 📦 Consegna finale

Salvate il file del modello `.mwb` e caricatelo nella cartella `progetti/ERM-videoteca` del repository GitHub del corso.
