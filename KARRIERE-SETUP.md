# BEKA - Karriere System Dokumentation

## Status: ERFOLGREICH EINGERICHTET

Das Karriere-System wurde vollständig implementiert basierend auf dem Ossenberg-Engels Projekt.

## Überblick

Das System ermöglicht die Verwaltung von Stellenangeboten (Job Offers) mit umfangreichen Feldern und Taxonomien.

### Implementierte Komponenten

1. **Custom Post Type: Stellenangebote**
2. **ACF Felder für detaillierte Jobbeschreibungen**
3. **Zwei Taxonomien: Kategorien & Vertragsarten**
4. **Single Template für Stellenanzeigen**
5. **Karriere Übersichtsseite**

## Dateistruktur

```
wp-content/themes/beka/
├── inc/
│   ├── post-types/
│   │   └── stellenangebote.php          # Custom Post Type Definition
│   └── acf-fields/
│       └── stellenangebote-fields.php   # ACF Feld-Definitionen
├── single-stellenangebote.php           # Template für einzelne Jobs
└── functions.php                        # Aktualisiert mit Includes
```

## Custom Post Type: Stellenangebote

### Eigenschaften
- **Slug**: `karriere/job/[job-name]`
- **Has Archive**: Nein (wird über Karriere-Seite angezeigt)
- **Supports**: Title, Editor, Revisions, Custom Fields
- **Menu Position**: 20 (nach Posts)
- **Menu Icon**: dashicons-id-alt

### Funktionen
- `beka_register_stellenangebote_post_type()` - Registriert den Post Type
- `beka_register_stellenangebote_category_taxonomy()` - Kategorien
- `beka_register_stellenangebote_contract_type_taxonomy()` - Vertragsarten
- `beka_stellenangebote_insert_default_taxonomies()` - Erstellt Standard-Taxonomien
- `beka_stellenangebote_sanitize_data()` - Sicherheits-Validierung

## Taxonomien

### Kategorien (stellenangebote_category)
Vordefinierte Kategorien:
- Produktion
- Verwaltung
- Ausbildung
- Praktikum

### Vertragsarten (stellenangebote_contract_type)
Vordefinierte Typen:
- Vollzeit (fulltime)
- Teilzeit (parttime)
- Ausbildung (apprentice)
- Praktikum (intern)

## ACF Felder

### Tabs und Hauptfelder

#### 1. Startdatum
- **Feld**: `start_date`
- **Typ**: Text
- **Beispiel**: "Ab sofort", "Ab 14. Dezember 2025"

#### 2. Tab: Ausbildungsinhalte
Für Ausbildungen/Praktika:
- **ausbildung_title**: Überschrift (Standard: "Ausbildungsinhalte:")
- **ausbildung_content**: WYSIWYG Editor für flexible Inhalte

#### 3. Tab: Aufgaben
- **tasks_title**: Überschrift (Standard: "Ihre Aufgaben:")
- **tasks**: Repeater mit Aufgaben-Items

#### 4. Tab: Profil
- **profile_title**: Überschrift (Standard: "Ihr Profil:")
- **profile**: Repeater mit Profil-Anforderungen

#### 5. Tab: Perspektiven
- **perspectives_title**: Überschrift (Standard: "Ihre Perspektiven:")
- **perspectives_content**: WYSIWYG Editor für Benefits

#### 6. Tab: Zusätzliche Sektionen (Optional)
- **additional_sections**: Repeater für beliebig viele Custom-Sektionen
  - section_title
  - section_content (WYSIWYG)

#### 7. Tab: Bewerbung
- **application_postal_title**: Überschrift
- **application_postal**: Postalische Adresse (Textarea)
- **application_is_email**: True/False für E-Mail vs. Link
- **application_email**: E-Mail-Adresse (conditional)
- **application_email_subject**: Betreff (conditional)
- **application_link**: Link-Feld (conditional)

## Template: single-stellenangebote.php

### Features
- Responsive Design mit TailwindCSS
- Dark Mode Support
- Alpine.js für Interaktivität
- Accordion für Details-Sektion
- Zurück-Button zur Karriere-Seite
- Badge-System für Kategorien und Vertragsarten
- Strukturierte Darstellung aller ACF-Felder

### Sektionen
1. Header mit Zurück-Button
2. Titel und Meta-Informationen
3. Accordion "Details zur Stelle"
   - Ausbildungsinhalte (conditional)
   - Aufgaben
   - Profil
   - Perspektiven
   - Zusätzliche Sektionen
4. Bewerbungssektion
   - Postalische Adresse
   - E-Mail oder Link-Button

## Beispiel-Stellenangebote

Drei Beispiel-Jobs wurden erstellt:

### 1. Projektleiter (m/w/d)
- **Kategorie**: Verwaltung
- **Vertragsart**: Vollzeit
- **Start**: Ab sofort
- **URL**: /karriere/job/projektleiter-renovierung-modernisierung/

### 2. Maler und Lackierer (m/w/d)
- **Kategorie**: Produktion
- **Vertragsart**: Vollzeit
- **Start**: Ab sofort oder nach Vereinbarung
- **URL**: /karriere/job/maler-lackierer/

### 3. Ausbildung Maler/Lackierer
- **Kategorie**: Ausbildung
- **Vertragsart**: Ausbildung
- **Start**: Ab August 2025
- **URL**: /karriere/job/ausbildung-maler-lackierer/

## Karriere Seite

- **Page ID**: 575
- **Slug**: karriere
- **URL**: http://localhost:8000/karriere/

Diese Seite dient als Übersicht für alle Stellenangebote.

## Admin-Ansicht

### Custom Columns
Im Admin-Bereich werden folgende Spalten angezeigt:
- Titel
- Kategorie
- Vertragsart
- Startdatum
- Datum

Alle Custom Columns sind sortierbar.

## Sicherheit

### Validierung
- E-Mail-Adressen werden mit `is_email()` validiert
- URLs werden mit `esc_url_raw()` sanitiert
- Berechtigungsprüfungen bei Speichervorgängen
- Autosave-Schutz

## Verwendung

### Neues Stellenangebot erstellen

1. WordPress Admin → Stellenangebote → Neu hinzufügen
2. Titel eingeben (z.B. "Elektriker (m/w/d)")
3. Content (optional) - erscheint nicht im Template, aber als Fallback
4. ACF Felder ausfüllen:
   - Startdatum
   - Aufgaben hinzufügen
   - Profil-Anforderungen hinzufügen
   - Perspektiven beschreiben
   - Bewerbungsinformationen eintragen
5. Kategorie und Vertragsart auswählen
6. Veröffentlichen

### Template Anpassung

Das Template `single-stellenangebote.php` kann frei angepasst werden:
- TailwindCSS Klassen für Styling
- Alpine.js für Interaktivität
- Dark Mode Klassen (`dark:`)

## Nächste Schritte

1. **Archive-Template erstellen** (optional)
   - `archive-stellenangebote.php` für Übersichtsseite

2. **Karriere-Seite gestalten**
   - Loop über Stellenangebote
   - Filter nach Kategorie/Vertragsart
   - Search-Funktion

3. **Bewerbungsformular** (optional)
   - Contact Form 7 oder Gravity Forms Integration
   - Custom Bewerbungsformular mit ACF

4. **E-Mail Benachrichtigungen**
   - Admin-Benachrichtigung bei neuer Bewerbung

## Maintenance

### Rewrite Rules aktualisieren
Falls URLs nicht funktionieren:
```php
// In functions.php temporär hinzufügen
flush_rewrite_rules();
```

Oder im Admin: Einstellungen → Permalinks → Speichern

### Taxonomien zurücksetzen
```php
delete_option('beka_stellenangebote_taxonomies_inserted');
// Dann Seite neu laden
```

## Support

Bei Fragen oder Problemen:
- Prüfen ob ACF Plugin aktiv ist
- Permalink-Struktur neu speichern
- PHP-Fehlerlog prüfen
- Browser-Konsole auf JavaScript-Fehler prüfen
