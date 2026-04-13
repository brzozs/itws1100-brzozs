# Lab 8 - JavaScript, JSON, and AJAX

**Sebastian Brzozowski**

## What this lab does

The projects page (`lab8.html`) loads with an empty container. On page load, `lab8.js` fires a jQuery AJAX call to read `lab8projects.json`. It iterates over the items in the JSON and dynamically builds a card for each project and appends it to the page — no hardcoded HTML needed for the project list.

## Files

- `lab8.html` — shell HTML page; contains no project data itself
- `lab8.js` — external JS file; does the AJAX call and builds the DOM
- `lab8.css` — page styles
- `lab8projects.json` — project data (title, description, link, category)

## jQuery / jQuery UI used

- `$.ajax()` — loads the JSON file
- `$.each()` — iterates over JSON items to build cards
- `.fadeIn()` / `.fadeOut()` — animates the category filter
- jQuery UI `.tooltip()` — adds tooltips to project links (from jQuery UI CDN)

jQuery and jQuery UI are both served from the official jQuery CDN.

## To add a new project

Open `lab8projects.json` and add a new object to the `menuItem` array with `title`, `description`, `link`, and `category` fields. The page will pick it up automatically on next load.

## Links

- GitHub Repo: [YOUR GITHUB REPO URL HERE]
- Azure Deployment: [YOUR AZURE URL HERE]
