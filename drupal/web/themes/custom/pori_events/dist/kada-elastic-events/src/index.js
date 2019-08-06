// This must be the first line in src/index.js
import 'react-app-polyfill/ie9';
import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';

const drupalElem = document.getElementById('kada-event-search');
const eventType = drupalElem.dataset.eventType;

let viewportWidth = window.innerWidth;
let filterOpen = true;
if (viewportWidth < 800) {
  filterOpen = true;
} else {
  filterOpen = false;
}

ReactDOM.render(
  <App eventType={eventType} filterOpen={filterOpen} />,
  drupalElem
);
