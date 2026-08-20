Saya sarankan cara eksekusinya

Walaupun master prompt di atas bisa langsung diberikan ke agent, jangan minta agent langsung mengerjakan 6 module sekaligus.

Lebih aman:

Sprint 1 — Foundation
Shared Layout
        ↓
Navigation
        ↓
Filter / Context
        ↓
Overview
        ↓
Kelembagaan
Sprint 2
Mutu Peserta Didik
Sprint 3
Sarpras
Sprint 4
Tata Kelola
Sprint 5
Laporan

Dan untuk setiap sprint, agent sebaiknya inspect → plan → implement → verify, bukan langsung generate banyak file.

Prompt lanjutan untuk menjalankan Module 1

Setelah memberikan master prompt, Anda bisa memberikan ini:

Now implement PHASE 1 only.


Start with:


1. Shared dashboard layout
2. Navigation
3. Global filter/context architecture
4. Overview
5. Kelembagaan


Do NOT implement Mutu Peserta Didik, Sarana Prasarana, Tata Kelola, or Laporan yet.


Before coding:
- inspect the existing project
- inspect current routes
- inspect models and relationships
- inspect instrument submission structure
- inspect existing UI components
- inspect existing styling conventions


Then provide an implementation plan.


After the plan is clear, implement the phase using real data.


Do not use mock data unless a UI state explicitly requires a placeholder, and clearly mark any placeholder.


After implementation:
- verify routes
- verify database queries
- verify empty states
- verify filter behavior
- verify school → assessment context navigation
- verify responsive layout
- check for N+1 queries
- report what was changed.

Menurut saya ini lebih aman daripada satu prompt "buat semua 6 module", karena project Anda sudah memiliki data-entry system yang berjalan. Kita ingin dashboard menjadi extension dari existing system, bukan membuat architecture kedua yang akhirnya sulit dirawat.