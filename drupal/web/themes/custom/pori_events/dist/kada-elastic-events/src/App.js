import React from "react";
import extend from "lodash/extend";
import {
  SearchkitManager,
  SearchkitProvider,
  SearchBox,
  RefinementListFilter,
  Pagination,
  NoHits,
  ResetFilters,
  ViewSwitcherHits,
  GroupedSelectedFilters,
  Layout,
  LayoutBody,
  LayoutResults,
  ActionBar,
  ActionBarRow,
  SideBar,
  QueryString,
  SearchkitComponent,
  Panel,
  MenuFilter,
  TermQuery
} from "searchkit";
import { DateRangeFilter, DateRangeCalendar } from "searchkit-datefilter";
import Moment from "moment";

const loc = window.location.origin;

let elasticServer = loc + "/api/search/searchkit/event-node";

const searchkit = new SearchkitManager(elasticServer);

searchkit.translateFunction = key => {
  let translations = {
    "searchbox.placeholder": Drupal.t("Search"),
    "NoHits.NoResultsFound": Drupal.t("No results found for") + " {query}",
    "pagination.previous": Drupal.t("Previous"),
    "pagination.next": Drupal.t("Next")
  };
  return translations[key];
};

const queryFields = [
  "title.autocomplete^10",
  "short_description",
  "area^5",
  "description^2"
];

const queryOptions = {
  phrase_slop: 2
};

const HitsListItem = props => {
  const { bemBlocks, result } = props;
  const source = extend({}, result._source, result.highlight);
  // If there's an url in the index, use it. Otherwise, fall back to Drupal node-id.
  const url = source.url ? source.url : "/node/" + result._id;
  const image_source = source.image_ext
    ? source.image_ext
    : "themes/custom/pori_events/dist/images/event-default.jpg";
  const title = source.title ? source.title : null;
  const leading = source.short_description ? source.short_description : null;

  const date_format = "D.M.YYYY";
  const time_format = "HH:mm";
  const date_start = Moment(source.start_time).format(date_format);
  const date_end = Moment(source.end_time).format(date_format);

  const time_start = Moment(source.start_time).format(time_format);
  const time_end = Moment(source.end_time).format(time_format);

  return (
    <div
      className={bemBlocks.item().mix(bemBlocks.container("item"))}
      data-qa="hit"
    >
      <div className={bemBlocks.item("title")}>
        <div className="event__image__wrapper">
          <img src={image_source} />
        </div>
        <div className="event__time">
          {date_start} - {date_end} klo {time_start} - {time_end}
        </div>
        <h2 className="event__title">
          <a href={url} dangerouslySetInnerHTML={{ __html: title }} />
        </h2>
        <div className="event__area">{source.area}</div>
        <div className="event__short_description">{leading}</div>
      </div>
    </div>
  );
};

class App extends SearchkitComponent {
  componentDidMount() {
    let filter = "0";
    if (this.props.eventType === "hobbies") {
      filter = "1";
    }
    searchkit.addDefaultQuery(query => {
      return query.addQuery(TermQuery("is_hobby", filter)).setSort([
        {
          single_day: "desc",
          start_time: "asc"
        }
      ]);
    });
  }
  render() {
    return (
      <SearchkitProvider searchkit={searchkit}>
        <Layout>
          <LayoutBody>
            <SideBar>
              <SearchBox
                autofocus={false}
                searchOnChange={true}
                queryFields={queryFields}
                prefixQueryFields={queryFields}
                queryOptions={queryOptions}
                prefixQueryOptions={queryOptions}
                queryBuilder={QueryString}
                id="keyword"
              />

              <Panel
                className={`${this.props.eventType}--what`}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("What")}
              >
                <RefinementListFilter
                  id="event_type"
                  field="event_type"
                  operator="OR"
                  size={100}
                />
              </Panel>
              <Panel
                className={`${this.props.eventType}--what-panel`}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("What")}
              >
                <RefinementListFilter
                  id="hobby_category"
                  field="hobby_category"
                  operator="OR"
                  size={100}
                />
              </Panel>

              <Panel
                className={`${this.props.eventType}--where`}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("Where")}
              >
                <RefinementListFilter
                  id="area"
                  field="area"
                  title="Area"
                  operator="OR"
                  size={100}
                />
              </Panel>
              <Panel
                className={`${this.props.eventType}--where-panel`}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("Where")}
              >
                <RefinementListFilter
                  id="hobby_area"
                  field="hobby_area"
                  title="Area"
                  operator="OR"
                  size={100}
                />
              </Panel>

              <Panel
                className={this.props.eventType}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("When")}
              >
                <DateRangeFilter
                  id="event_date"
                  fromDateField="start_time"
                  toDateField="end_time"
                  calendarComponent={DateRangeCalendar}
                />
              </Panel>

              <Panel
                className={`${this.props.eventType}--whom-panel`}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("For whom")}
              >
                <RefinementListFilter
                  id="audience"
                  field="audience"
                  operator="OR"
                  size={100}
                />
              </Panel>
              <Panel
                className={`${this.props.eventType}--whom`}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("For whom")}
              >
                <RefinementListFilter
                  id="hobby_audience"
                  field="hobby_audience"
                  operator="OR"
                  size={100}
                />
              </Panel>
              <Panel
                className={`${this.props.eventType}--refine-event`}
                collapsable={true}
                defaultCollapsed={true}
                title={Drupal.t("Refine your search")}
              >
                <MenuFilter
                  id="accessible"
                  field="accessible"
                  title="Accessible"
                  operator="OR"
                  size={100}
                />
                <MenuFilter
                  id="child_care"
                  field="child_care"
                  title="Child Care"
                  operator="OR"
                  size={100}
                />
                <MenuFilter
                  id="free"
                  field="free_enterance"
                  title="Free Entrance"
                  operator="OR"
                  size={100}
                />
                <MenuFilter
                  id="culture_and_or_activity_no"
                  field="culture_and_or_activity_no"
                  title="Culture and Activity card"
                  operator="OR"
                  size={100}
                />
              </Panel>
            </SideBar>

            <LayoutResults className={this.props.eventType}>
              <ActionBar>
                <ActionBarRow>
                  <GroupedSelectedFilters />
                  <ResetFilters
                    translations={{
                      "reset.clear_all": Drupal.t("Reset all filters")
                    }}
                  />
                </ActionBarRow>
              </ActionBar>
              <ViewSwitcherHits
                hitsPerPage={12}
                highlightFields={["title"]}
                hitComponents={[
                  { key: "list", title: "List", itemComponent: HitsListItem }
                ]}
                scrollTo="body"
              />
              <NoHits suggestionsField={"title"} />
              <Pagination showNumbers={true} />
            </LayoutResults>
          </LayoutBody>
        </Layout>
      </SearchkitProvider>
    );
  }
}

export default App;
