import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';

const drupalElem = document.getElementById('kada-event-search');
const eventType = drupalElem.dataset.eventType;


ReactDOM.render(
  <App eventType={eventType} />,
  drupalElem
);
