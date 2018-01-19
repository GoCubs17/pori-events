# README #

### Sass base structure ###
This repository is an example of a Sass structure which should be used when creating styles for your project.
The structure is and should be modular, reusable and divided to components, layouts, mixins and variables. 
This base structure shows a few examples and some generally used classes, like states. Bear in mind, that the provided examples have undergone [pattern exercise](http://alistapart.com/article/from-pages-to-patterns-an-exercise-for-everyone).  
 
### Class naming ###
  - Drupal coding standards: [Sub-components](https://www.drupal.org/coding-standards/css/architecture#sub-components) 
  - Drupal coding standards: [Extending](https://www.drupal.org/coding-standards/css/architecture#extend)
  - layout classes
    - `.l-foobar`
  - component classes
    - `.foobutton`
    - `.foobutton--variant`
    - `.foobutton__subcomponent`
  - state classes
    - `.is-state`
  - theme classes
    - `.theme-color`
  - javascript
    - Preferably use data attributes
    - Do not use presentation classes as js/jquery selectors
    - Add a proper functionality class and use that class in js/jquery 

### Grid system ###
  - Use Singularity, do not use other grid systems
  - This feature should always be used carefully. Don’t overuse it!
  - When not to use a grid system:
    - component layout changes a lot per responsive mode (for example different amount of items on the same row)
    - **need more examples here…**
  - When to use a grid system:
    - **need examples...** 

## As a reminder: Coding standards ##
  - No nesting deeper than 3 levels
  - Documentation of components and classes for styleguide purposes
    - **Will be decided later**
  - Line-breaks before each selector if there is another preceding selector or definition. We should use linter to check the formatting in the future **(example)**
  - Sass `@extend`
    - [Sass Best Practices - @extends](https://github.com/mobify/mobify-code-style/tree/master/css/sass-best-practices#extends)
    - Use placeholders, for example `@extend %myplaceholder`
    - Do not extend normal classes
  - Use libraries for everything. Don’t load CSS files to the global context ever so that unnecessary CSS doesn’t end up being in the global space. **(Directions how to use this)**
  - **(Create standards on how to separate CSS files loaded in the head and in the footer)**

### Other stuff ###
  - Mixins
    - Avoid overusing mixins for example making component styles with these
    - Good example when to use mixin: `@mixin vertically-center`
  - Z-index policy:
    - search the project for “z-index” to see what numbers are currently being used before deciding what z-index number you want to use
    - ideas if we want to do more: use variables? document the used z-index numbers so that they can be all seen in one place?
  - Vendor prefix policy:
    - We want sass code to be easy to read and excessive use of vendor prefixes does not help that
    - Idea 1: Make a list of properties which don’t need a vendor prefix
    - Idea 2: Use grunt automation or similiar which will add the vendor prefixes automatically depending on the project settings

### Font-size policies / Using measurement units (px/em/rem) ###
  - use px font-size on html or body element
    - [*Font Size Idea: px at the Root, rem for Components, em for Text Elements*](https://css-tricks.com/rems-ems/)
    - **+*- layout won’t break if user has some weird settings by accident
    - **-*- usability is reduced (our font-size will override browser font-size setting)
  - **When to use px? When to use em? When to use rem?**
    - if you use em, sometimes the relative margin/padding might get too big

### Variables ###
  - Colors
    - Will be named using the actual color name and shade, for example `$blue-dark` (instead of `$primary-color` or `$secondary-color`)

### Useful links ###
