# MUTU SMK — Dashboard & Analytics Implementation

## ROLE

You are a senior full-stack engineer and product engineer responsible for implementing the Mutu SMK dashboard.

The existing application is a Laravel-based application with server-rendered Blade forms and an existing instrument submission system.

Your task is NOT to rebuild the existing data-entry/instrument system.

Your task is to build a new dashboard/analytics experience on top of the existing data.

The dashboard must consume existing submission data and present it in a clear, professional, data-driven interface.

---

# 1. BUSINESS CONTEXT

Mutu SMK is a quality assessment and monitoring system for vocational schools.

The system does not only contain one expertise area.

Examples include:

- Bidang Keahlian Perikanan
- Bidang Keahlian Teknologi Informasi
- Bidang Keahlian Kemaritiman
- Other expertise areas

One school may have multiple expertise/program/concentration combinations.

Therefore:

School
    ↓
Multiple Assessments / Submissions
    ↓
Each submission belongs to a specific expertise/program/concentration context
    ↓
Each submission contains assessment sections
    ↓
Each section contains structured answers

Do NOT assume:

School = one submission.

The correct conceptual model is:

School
    └── Submission / Assessment
          ├── Period
          ├── Bidang Keahlian
          ├── Program Keahlian
          ├── Konsentrasi Keahlian
          └── Assessment Data

---

# 2. EXISTING ASSESSMENT STRUCTURE

The existing assessment consists of three major aspects:

A — Peserta Didik
B — Sarana Prasarana
C — Tata Kelola

Current section codes:

A.1.1
A.1.2
A.2.1
A.3
A.4

B.sapras

C.1.1
C.2.1
C.3.1
C.3.2
C.3.3

These section codes are part of the existing application and MUST NOT be renamed without explicit approval.

---

# 3. MODULE STRUCTURE

Implement six main dashboard modules:

1. Overview
2. Kelembagaan
3. Mutu Peserta Didik
4. Sarana Prasarana
5. Tata Kelola
6. Laporan

Navigation should conceptually be:

MUTU SMK
│
├── Overview
├── Kelembagaan
├── Mutu Peserta Didik
├── Sarana Prasarana
├── Tata Kelola
└── Laporan

Do not create separate top-level navigation items for A.1, A.2, A.3, etc.

Those are sub-sections within the relevant module.

---

# 4. GLOBAL UX / CONTEXT

The dashboard must support two analytical scopes.

## Scope A — Aggregated / Multi-School

Used by Overview and Kelembagaan.

Possible filters:

- Provinsi
- Kabupaten/Kota
- Bidang Keahlian
- Program Keahlian
- Periode/Tahun
- Status Sekolah
- Status Submission

The interface should make it clear that the user is looking at aggregated data.

---

## Scope B — School / Assessment Context

Used when the user is analyzing one specific school.

Context:

- School
- Bidang Keahlian
- Program Keahlian
- Konsentrasi Keahlian
- Periode

Example:

School:
SMK SWASTA BUDAYA LANGKAT

Bidang:
Teknologi Informasi

Program:
Teknik Jaringan Komputer dan Telekomunikasi

Konsentrasi:
Teknik Komputer dan Jaringan

Periode:
2025/2026

This context should remain consistent when navigating between:

Profil
Mutu Peserta Didik
Sarpras
Tata Kelola

Do not make the user repeatedly select the same context on every page.

---

# 5. IMPORTANT DATA RULE

The existing submission data is the source of truth.

Do NOT create fake dashboard data.

Do NOT invent metrics that are not supported by existing data.

Do NOT invent an overall "Mutu Score" such as 80/100 unless a formal scoring/bobot definition exists.

At the current stage:

Prefer:

- KPI
- Count
- Percentage
- Distribution
- Trend
- Compliance
- Readiness
- Gap
- Status
- Comparison
- Evidence / Notes

Do not call a calculated percentage a "score" unless it is officially defined as a score.

---

# 6. DATA ARCHITECTURE

Existing conceptual structure:

schools
    ↓
instrument_submissions_v2
    ↓
instrument_submission_v2_details
    ↓
section_code
    ↓
data JSON

Keep the existing source-of-truth structure.

Do NOT duplicate every dashboard metric into separate dashboard tables unless there is a demonstrated performance requirement.

The dashboard should initially use a read/analytics/query layer over the existing data.

If performance becomes an issue later, introduce projections/read models deliberately.

Avoid premature optimization.

---

# 7. DATA TYPES

The dashboard must recognize different kinds of assessment data.

## Quantitative

Examples:

- total students
- total graduates
- teacher count
- student count
- equipment quantity
- percentage
- average score

UI:

- KPI cards
- charts
- trends
- comparison

---

## Binary / Checklist

Example:

B.2.1

Checklist:

- Layout industry
- Calibration
- SOP availability
- K3 implementation

Values:

yes / no

UI:

- Compliance percentage
- Checklist status
- Readiness
- Gap
- Failed items

Do NOT convert checklist values into arbitrary scores.

---

## Qualitative

Examples:

- notes
- remarks
- constraints
- qualitative contribution
- explanations

UI:

- Findings
- Notes
- Evidence
- Detail panel

Do not force qualitative data into charts.

---

# 8. MODULE 1 — OVERVIEW

## Goal

Answer:

"Bagaimana kondisi umum mutu SMK berdasarkan data yang tersedia?"

Overview is an aggregation dashboard.

It should NOT simply reproduce A/B/C input forms.

---

## Layout

Header:

Overview
Gambaran umum mutu SMK

Global filters:

- Provinsi
- Kabupaten/Kota
- Bidang Keahlian
- Program Keahlian
- Periode

Summary KPI:

- Total Sekolah
- Total Submission / Assessment
- Total Bidang Keahlian
- Total Konsentrasi Keahlian

Then:

### Distribusi Bidang Keahlian

Show distribution of schools/submissions by expertise.

Examples:

- Teknologi Informasi
- Perikanan
- Kemaritiman
- Other available values

Use chart appropriate to the actual data distribution.

---

### Mutu Peserta Didik Summary

Summarize available A indicators:

- UKK
- Sertifikasi
- Tracer Study
- Putus Sekolah
- TKA

Do not invent an overall A score.

---

### Sarana Prasarana Summary

Summarize available B indicators.

Examples:

- facility readiness
- equipment readiness
- checklist compliance
- identified gaps

Only show metrics that can actually be calculated from existing B data.

---

### Tata Kelola Summary

Summarize:

- Kerjasama Industri
- Teaching Factory
- Guru & Ketenagaan

Again, do not invent scoring.

---

### Priority / Attention Area

If data supports it, show:

- failed checklist items
- missing data
- identified gaps
- indicators with low achievement
- indicators requiring attention

Do not fabricate recommendations.

Recommendations must be derived from actual data.

---

# 9. MODULE 2 — KELEMBAGAAN

## Goal

Answer:

"Siapa sekolahnya, di mana lokasinya, bagaimana statusnya, dan apa struktur keahliannya?"

This module focuses on school identity and institutional structure.

---

## Kelembagaan Overview

Summary:

- Total Sekolah
- Total Provinsi
- Total Bidang Keahlian
- Total Konsentrasi

Charts/distributions where supported:

- Status Sekolah
- Akreditasi
- Wilayah
- Bidang Keahlian
- Kategori Sekolah

Then:

### School Directory

Columns should be based on existing data.

Possible columns:

- Nama Sekolah
- NPSN
- Provinsi
- Kabupaten/Kota
- Status
- Kategori
- Akreditasi
- Bidang Keahlian

Provide:

- search
- filter
- pagination
- sorting where appropriate

Do not overload the table.

---

# 10. SCHOOL DETAIL

When selecting a school:

Show:

## Identitas

- Nama Sekolah
- NPSN
- Alamat
- Provinsi
- Kabupaten/Kota
- Status
- Kategori
- Akreditasi
- Kurikulum
- Durasi Program

---

## Struktur Keahlian

Display:

School
    ↓
Bidang Keahlian
    ↓
Program Keahlian
    ↓
Konsentrasi Keahlian

This must support multiple combinations.

---

## Assessment / Submission

Show available submissions:

Example:

2025/2026
    Teknologi Informasi / TKJ
    Status: Submitted

2025/2026
    Perikanan / ...
    Status: Draft

The user should be able to select an assessment and enter the assessment-specific dashboard context.

---

# 11. MODULE 3 — MUTU PESERTA DIDIK

Structure:

Mutu Peserta Didik
│
├── A.1 Kompetensi
│   ├── A.1.1 UKK & Sertifikasi
│   └── A.1.2 Skema Sertifikasi & KKNI
│
├── A.2 Tracer Study
│   └── A.2.1
│
├── A.3 Putus Sekolah
│
└── A.4 TKA

---

## A.1.1 UKK

Possible analytics:

- total participants
- total passed
- pass rate
- year-over-year trend
- certification distribution if supported

Do not assume percentages if raw data does not support them.

---

## A.1.2 Certification / KKNI

Possible:

- certification scheme
- KKNI level
- competency units
- compliance
- remarks

Use cards/tables rather than unnecessary charts.

---

## A.2.1 Tracer Study

Possible:

- total graduates
- employment
- waiting time
- job relevance
- user satisfaction
- entrepreneurship
- continuing education

Important:

Validate the meaning/unit of each quantitative field before presenting percentages or scores.

Do not assume that a numeric value means percentage.

---

## A.3

Show:

- initial students
- final students
- dropouts
- failed students
- dropout percentage
- main factors

Trend by year where data supports it.

---

## A.4 TKA

Show:

- national average
- school average
- difference

Possible visualization:

School vs National comparison.

Do not create a generic score.

---

# 12. MODULE 4 — SARANA PRASARANA

Structure:

Sarana Prasarana
│
├── Overview
├── Facility Readiness
├── Equipment
├── K3
├── Infrastructure
└── Gap / Findings

The exact subcategories must follow the actual existing section structure.

Do not invent categories that are not present in the source data.

---

## IMPORTANT: CHECKLIST DATA

Example B.2.1:

Checklist items:

- layout_industry
- calibration
- sop_available
- k3_implementation

Each:

yes / no
+
optional notes

Dashboard should derive:

- fulfilled items
- unfulfilled items
- readiness/compliance percentage
- list of failed items
- notes/findings

Example:

Facility Readiness
3 / 4 fulfilled
75%

✓ Layout industry
✓ Calibration
✕ SOP availability
✓ K3 implementation

---

## Sarpras Context

Sarpras may depend on:

- Bidang Keahlian
- Program
- Konsentrasi

Therefore the dashboard must respect the assessment context.

Do not aggregate incompatible concentrations without clear context.

---

# 13. MODULE 5 — TATA KELOLA

Structure:

Tata Kelola
│
├── C.1 Kerjasama Industri
│   └── C.1.1
│
├── C.2 Teaching Factory
│   └── C.2.1
│
└── C.3 Guru & Ketenagaan
    ├── C.3.1
    ├── C.3.2
    └── C.3.3

---

## C.1.1 Kerjasama Industri

If data contains multiple partners:

Show:

- total partners
- MOU status
- duration
- program collaboration
- recruitment
- internship
- certification
- training
- TEFA
- other collaboration

Use:

- summary
- partner table
- distribution
- detail drawer

Do not reduce all partner information into one arbitrary score.

---

## C.2.1 Teaching Factory

Show:

- TEFA category
- product
- description
- industry partner
- implementation stages
- certification
- curriculum synchronization
- branding / HAKI
- quality evaluation
- revenue activity
- industry contribution
- constraints

This is a mixed structured + qualitative dataset.

Use summary cards + status matrix + detail table.

---

## C.3.1 Teacher Training

Show:

- teacher
- subject
- competency type
- training
- year
- provider
- duration
- evidence

Use table + filters.

---

## C.3.2 Training Needs

Show:

- current condition
- gap
- identified needs

Prioritize qualitative presentation.

---

## C.3.3 Teacher Capacity

Show:

- concentration
- teacher count
- student count
- ideal ratio
- actual ratio
- productive teacher count
- ideal productive ratio
- gap

This is suitable for:

- ratio KPI
- comparison
- gap visualization
- concentration table

---

# 14. MODULE 6 — LAPORAN

The reporting module should be based on the same analytics layer.

Possible report types:

## School Report

One school + one assessment context.

Includes:

- profile
- A
- B
- C
- findings
- gaps

---

## Regional Report

Aggregated:

- province
- regency/city
- expertise
- period

---

## Comparative Report

Examples:

- school vs regional
- school vs expertise
- one period vs another period

Only implement comparisons supported by the data.

---

## Export

Depending on existing project requirements:

- PDF
- Excel
- CSV

Do not implement export before the underlying dashboard queries are stable.

---

# 15. GLOBAL COMPONENTS

Create reusable components.

Examples:

- DashboardHeader
- GlobalFilterBar
- ContextSelector
- KpiCard
- MetricCard
- SectionCard
- ChartCard
- StatusBadge
- ProgressIndicator
- ComparisonCard
- DataTable
- DetailDrawer
- EmptyState
- LoadingState
- ErrorState
- FilterChip
- Breadcrumb
- AssessmentContext

Do not create duplicated markup for each page.

---

# 16. CONTEXT SELECTOR

For school-specific pages, provide a reusable context selector:

School
    ↓
Bidang Keahlian
    ↓
Program Keahlian
    ↓
Konsentrasi Keahlian
    ↓
Periode

When the user changes context:

- update the dashboard data
- preserve context when navigating between modules
- do not reload unrelated data unnecessarily

---

# 17. UX PRINCIPLES

The dashboard should feel like a professional government/education analytics product.

Avoid:

- excessive cards
- excessive gradients
- giant numbers everywhere
- decorative charts
- fake data
- unnecessary animation
- excessive rounded containers
- dashboard clutter

Prioritize:

- hierarchy
- readability
- whitespace
- clear typography
- consistent spacing
- meaningful visualizations
- clear filtering
- data provenance
- responsive behavior

The user should understand the most important information within a few seconds.

---

# 18. RESPONSIVE DESIGN

Support:

- desktop
- tablet
- mobile

Desktop is the primary target for the analytics dashboard.

Tables should become horizontally scrollable or transform into appropriate mobile layouts.

Do not simply shrink desktop tables until they become unusable.

---

# 19. DATA STATES

Every dashboard widget must handle:

1. Loading
2. Loaded
3. Empty
4. Error

Empty is NOT the same as zero.

Example:

"No data submitted for this assessment."

is different from:

"0 students."

Do not display zero when the underlying data is missing.

---

# 20. DATA VALIDATION

Before implementing calculations:

Inspect:

- database schema
- model relationships
- JSON structures
- existing services
- existing queries
- existing section codes
- existing submission lifecycle

Do not guess.

If a metric's unit or meaning is ambiguous, preserve the raw value and flag it for validation rather than inventing an interpretation.

---

# 21. PERFORMANCE

Avoid:

- N+1 queries
- loading every JSON answer into PHP unnecessarily
- querying all submissions repeatedly for every widget
- duplicate aggregation queries

Prefer:

- reusable query/service layer
- scoped queries
- eager loading where appropriate
- aggregation in database when practical
- caching only after identifying actual expensive queries

---

# 22. IMPLEMENTATION ORDER

Do NOT implement all six modules simultaneously.

Use this sequence:

PHASE 1
1. Shared layout
2. Navigation
3. Global filter/context
4. Overview
5. Kelembagaan

PHASE 2
6. Mutu Peserta Didik

PHASE 3
7. Sarana Prasarana

PHASE 4
8. Tata Kelola

PHASE 5
9. Laporan

---

# 23. PHASE 1 ACCEPTANCE CRITERIA

Before proceeding to Phase 2:

Overview must have:

- working filters
- real school count
- real submission count
- expertise distribution
- available A/B/C summaries
- proper empty states
- responsive layout

Kelembagaan must have:

- school list
- search
- filters
- pagination
- school detail
- school identity
- expertise/program/concentration hierarchy
- submission list
- ability to select an assessment context

No fake metrics.

---

# 24. IMPORTANT DEVELOPMENT RULE

Before writing code:

1. Inspect existing project structure.
2. Identify current routes.
3. Identify existing controllers/services.
4. Identify models and relationships.
5. Identify existing Blade/React components.
6. Identify current UI conventions.
7. Identify existing CSS/framework.
8. Reuse existing components where appropriate.
9. Do not create a parallel architecture unnecessarily.

Then propose the implementation plan.

Only after understanding the existing architecture should implementation begin.

---

# 25. DESIGN LANGUAGE

The visual language should be:

Professional
Clean
Institutional
Data-oriented
Modern
Trustworthy

Use visual hierarchy instead of decoration.

Suggested hierarchy:

Page title
    ↓
Context / Filter
    ↓
Primary KPI
    ↓
Analysis
    ↓
Detail
    ↓
Evidence

---

# 26. OUTPUT EXPECTATION

For each module, provide:

1. Route
2. Controller / Action
3. Query / Service
4. Data mapping
5. UI structure
6. Components
7. Empty states
8. Loading states
9. Error states
10. Responsive behavior
11. Acceptance criteria

Do not just create a UI mockup.

The result must be connected to real application data.

---

# 27. FINAL PRODUCT STRUCTURE

The final application should conceptually look like:

MUTU SMK
│
├── Overview
│   ├── Global Statistics
│   ├── Expertise Distribution
│   ├── Peserta Didik Summary
│   ├── Sarpras Summary
│   ├── Tata Kelola Summary
│   └── Attention Areas
│
├── Kelembagaan
│   ├── School Directory
│   └── School Detail
│       ├── Identity
│       ├── Expertise Structure
│       └── Assessments
│
├── Mutu Peserta Didik
│   ├── A.1 Kompetensi
│   ├── A.2 Tracer Study
│   ├── A.3 Putus Sekolah
│   └── A.4 TKA
│
├── Sarana Prasarana
│   ├── Overview
│   ├── Readiness
│   ├── Equipment
│   ├── K3
│   └── Gap
│
├── Tata Kelola
│   ├── Kerjasama Industri
│   ├── Teaching Factory
│   └── Guru & Ketenagaan
│
└── Laporan
    ├── School Report
    ├── Regional Report
    └── Comparative Report

The architecture must remain extensible for additional expertise areas and additional assessment indicators in the future.