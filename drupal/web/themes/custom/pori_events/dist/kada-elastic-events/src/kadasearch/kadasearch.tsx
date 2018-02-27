import * as React from "react";
import * as moment from "moment";
import { EventListItem } from "./HitItems";
import Drupal from "../DrupalSettings";
import DrupalSettings from "../DrupalSettings";

var MultiSelect = require('searchkit-multiselect');

declare var window;

import {
  SearchBox,
  Hits,
  HitsStats,
  RefinementListFilter,
  ResetFilters,
  GroupedSelectedFilters,
  SearchkitComponent,
  SearchkitProvider,
  SearchkitManager,
  NoHits,
  Pagination,
  ItemHistogramList,
  Layout, LayoutBody, LayoutResults,
  SideBar,
  Panel,
  ActionBar, ActionBarRow,
  QueryString
} from "searchkit";

import HierarchicalRefinementFilter from './HierarchicalRefinementFilter'
import RefinementWithText from './RefinementWithText'
import { DateRangeFilter } from './DateRangeFilter'
import { DateRangeCalendar } from './DateRangeCalendar'
import { DateRangeQuery } from "./query/DateRangeQuery";

import "./styles/theme.scss";

const CollapsablePanel = (<Panel collapsable={true} defaultCollapsed={false} />);
const CollapsedPanel = (<Panel collapsable={true} defaultCollapsed={true} />);

// @todo: some of the fields containing searcheable data are deactivated for
// now, so the client can test what works best for them. When this is
// considered stable, it will make sense to remove the fields entirely from the
// search options.
const eventsQueryFields = [
 "title^10",
 "title.autocomplete^2",
]


// Available query options:
// https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl-query-string-query.html
const queryOptions = {
  fuzziness: 0,
  phrase_slop: 2,
}
const prefixQueryOptions = {
  fuzziness: 0,
  phrase_slop: 2,
}
let elasticServer = null;
if (!DrupalSettings.noDrupal) {
  const host = window.location.origin;
  elasticServer = host + '/api/search/searchkit/event-node';
} else {
  elasticServer = DrupalSettings.elasticServer;
}

const currentCalendar=  'events';
let SearchServer = elasticServer;
let SearchCalendar = currentCalendar;
let SearchLanguage = DrupalSettings.path.currentLanguage;
let SearchIndex = SearchCalendar + '_' + SearchLanguage;
let SearchServerURL = SearchServer;


export class KadaSearch extends React.Component<any, any> {
  searchkit: SearchkitManager;

  constructor() {
    super();
    // new searchkit Manager connecting to ES server
    const host = SearchServerURL;
    this.searchkit = new SearchkitManager(host, {
      // Disable history for now so text searches don't mess up Drupal with
      // the q parameter in the query string.
      useHistory: false,
    });

    // Attach translations to Drupal
    this.searchkit.translateFunction = (key) => {
      let translations = {
        "searchbox.placeholder": window.Drupal.t("Search"),
        "pagination.previous": window.Drupal.t("Previous"),
        "pagination.next": window.Drupal.t("Next"),
        "reset.clear_all": window.Drupal.t("Clear all filters"),
        "facets.view_more": window.Drupal.t("View more"),
        "facets.view_less": window.Drupal.t("View less"),
        "facets.view_all": window.Drupal.t("View all"),
        "NoHits.NoResultsFound": window.Drupal.t("No results found for {query}"),
        "NoHits.DidYouMean": window.Drupal.t("Search for {suggestion}."),
        "NoHits.SearchWithoutFilters": window.Drupal.t("Search for {query} without filters"),
        "NoHits.NoResultsFoundDidYouMean": window.Drupal.t("No results found for {query}. Did you mean {suggestion}?"),
        "hitstats.results_found": window.Drupal.t("{hitCount} results found in {timeTaken} ms"),
      };
      return translations[key];
    };
  }

  render() {
    return (
      <SearchkitProvider searchkit={this.searchkit}>
        <Layout size="l">
          <LayoutBody>

            <SideBar>
              <SearchBox
                autofocus={false}
                searchOnChange={true}
                queryFields={eventsQueryFields}
                prefixQueryFields={eventsQueryFields}
                queryOptions={queryOptions}
                prefixQueryOptions={prefixQueryOptions}
                queryBuilder={QueryString}
              />
            </SideBar>

            <LayoutResults>

              <ActionBar>
                <ActionBarRow>
                  <HitsStats/>
                </ActionBarRow>
              </ActionBar>

              <Pagination
                showNumbers={true}
                pageScope={2}
              />

              <div className="clearfix">
                <Hits
                  itemComponent={EventListItem}
                  hitsPerPage={10}
                  highlightFields={[
                    "title",
                  ]}
                  scrollTo=".sk-layout"
                />
              </div>

              <NoHits
                suggestionsField="title_field"
              />

              <Pagination
                showNumbers={true}
                pageScope={2}
              />

            </LayoutResults>
          </LayoutBody>

        </Layout>
      </SearchkitProvider>
    );
  }
}
