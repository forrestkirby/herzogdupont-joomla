# Changelog

## 1.9.0

### Added

- justify grid parallax option to slideshow grid element
- aria label for range slider in image comparison element
- expand to title grid width option to flipcard, slidehow grid and timeline elements
- expand content option to slideshow grid element
- height expand option to flipcard element
- text color option for transparent header to flipcard, image comparison and timeline elements

### Changed

- replace UIkit `isVisible` function by `IntersectionObserver` in counter and lottie element
- YOOtheme Pro 5.0.0 compatibility
- raised minimum YOOtheme Pro version to 5.0.0

### Fixed

- automatically recompile style
- fix item margin top not applied in timeline element

## 1.8.0

### Added

- HTML element option to flipcard and multiple items elements
- source option to all multiple items elements
- option to transform element type into another
- aria label option for links across all elements
- focal point option for image cropping across all elements
- option to remove margin to image comparison element

### Changed

- raised minimum Joomla version to 4.0.0
- raised minimum PHP version to 8.0.0
- raised minimum YOOtheme Pro version to 4.0.0
- replace UIkit `isInView` function by UIkit `isVisible` function in counter and lottie element

## 1.7.1

### Fixed

- error if percentage is empty in counter element
- render conditions in toggle element

## 1.7.0

### Added

- animation name to lottie element
- automatically recompile style
- loading eager option for images across all elements
- transition border option to timeline element
- before/after labels to image comparison element

### Changed

- improve performance for event listening in lottie element
- card will not flip back when a link is clicked in flipcard element
- revert fixed centered alignment in Safari in counter element
- raised minimum YOOtheme Pro version to 3.0.0

### Fixed

- resize canvas on viewport resize in lottie element
- item container width in timeline element
- rendering of grid items depending on display settings in timeline element

## 1.6.3 (February 21, 2022)

### Changed

- use namespace to avoid conflicts with other extensions for YOOtheme Pro

## 1.6.2 (December 24, 2021)

### Removed

- option to disable pointer events for absolute positioned builder elements

## 1.6.1 (December 22, 2021)

### Changed

- raised minimum PHP version to 7.4
- raised minimum YOOtheme Pro version to 2.7.9

### Fixed

- initialization if after image load event is not triggered in image comparison element
- notice about undefined index in flipcard element

## 1.6.0 (December 16, 2021)

### Added

- option to disable pointer events for absolute positioned builder elements

## 1.5.3 (December 02, 2021)

### Fixed

- panel padding update path in flipcard element
- missing classes on cards in flipcard element

## 1.5.2 (December 02, 2021)

### Changed

- show style customizer panel for timeline element only if element is enabled

### Fixed

- warning about undefined array key in timeline element

## 1.5.1 (December 01, 2021)

### Changed

- replaced CSS by LESS to use breakpoints of style customizer in timeline element
- raised minimum YOOtheme Pro version to 2.7

### Fixed

- tile style options in timeline and flipcard elements
- layout update for card padding when set on items

## 1.5.0 (November 18, 2021)

### Added

- tile style options to timeline, flipcard and slideshow grid elements
- heading options to content style across all elements
- text lead option to meta style across all elements
- text lead and meta options to title style across all elements

### Fixed

- center content vertically if image is left/right aligned in slideshow grid element

## 1.4.1 (October 22, 2021)

### Fixed

- animation path in lottie element

## 1.4.0 (October 22, 2021)

### Added

- flip mode touch options to flipcard element
- figcaption to content.php in image comparison element
- lottie element
- navigation large margin option to slideshow grid element

### Fixed

- nav if image is skipped in slideshow grid element
- initialization in Safari in image comparison element

## 1.3.1 (August 09, 2021)

### Fixed

- initialization in throttled networks and Safari in image comparison element

## 1.3.0 (July 06, 2021)

### Added

- link text option for items in timeline element
- full width option for buttons across all elements
- option to animate the element or its items
- slideshow grid element
- color options to progress element

### Changed

- raised minimum YOOtheme Pro version to 2.5
- renamed `value` field to `start` in progress element

### Removed

- obsolete margin classes in progress element

### Fixed

- update script breaks builder library in timeline element
- images not being clipped for round cards in timeline and flipcard elements
- render empty `<div>` if content field is empty in progress element
- link styles if whole panel is linked in panel based elements

## 1.2.1 (May 02, 2021)

### Changed

- JED compliance

## 1.2.0 (April 09, 2021)

### Added

- flip mode options to flipcard element

## 1.1.2 (March 31, 2021)

### Fixed

- initialization if lazy loading is disabled in image comparison element

## 1.1.1 (March 10, 2021)

### Fixed

- centered alignment in Safari in counter element

## 1.1.0 (March 09, 2021)

### Added

- panel style option to timeline item element

### Fixed

- left/right aligned images not covering cards with different heights in flipcard element

## 1.0.0 (February 20, 2021)

### Added

- initial release
