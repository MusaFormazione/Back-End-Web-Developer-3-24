# NodeApp

Una semplice applicazione Node.js che utilizza MySQL come database.

## 🛠 Requisiti

- [Node.js](https://nodejs.org/) (v14+ consigliato)
- Un database MySQL accessibile con le credenziali fornite

## 📦 Installazione

Clona il repository e installa le dipendenze:

```bash
git clone <repo-url>
cd mysql/nodeMySQLClient
npm install
```
## 📦 Uso

Modifica il file `package.json`, inserisci le credenziali degli utenti che hai definito nel tuo database server.

```bash
  "scripts": {
    "dev_user1": "node index.js user1 password1",
    "dev_user2": "node index.js user2 password2"
  },
```

Poi esegui nel tuo terminale uno dei seguenti comandi

```bash
npm run dev_user1
```

```bash
npm run dev_user_2
```