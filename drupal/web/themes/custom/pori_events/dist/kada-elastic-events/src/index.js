import 'react-app-polyfill/ie9';
import 'react-app-polyfill/ie11';
import 'react-app-polyfill/stable';
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
