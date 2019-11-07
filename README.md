<h1 align="center">MarkShust_HierarchyComplexIdCompatibility</h1> 

<div align="center">
  <p>The Hierarchy Complex ID Compatibility module makes the hierarchy compatible with long URL identifiers containing subpaths.</p>
  <img src="https://img.shields.io/badge/magento-^2.3 commerce-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
  <a href="https://packagist.org/packages/markshust/magento2-module-hierarchycomplexidcompatibility" target="_blank"><img src="https://img.shields.io/packagist/v/markshust/magento2-module-hierarchycomplexidcompatibility.svg?style=flat-square" alt="Latest Stable Version" /></a>
  <a href="https://packagist.org/packages/markshust/magento2-module-hierarchycomplexidcompatibility" target="_blank"><img src="https://poser.pugx.org/markshust/magento2-module-hierarchycomplexidcompatibility/downloads" alt="Composer Downloads" /></a>
  <a href="https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity" target="_blank"><img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square" alt="Maintained - Yes" /></a>
  <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/license-MIT-blue.svg" /></a>
</div>

## Table of contents

- [Summary](#summary)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Summary

The hierarchy functionality of Magento Commerce prepends the URL identifier of parent nodes to children. This is ok for CMS pages with standard, simple URLs.

However, if the URL contains subpaths the hierarchy request paths will be setup incorrectly, leading to undesired route locations and breadcrumb links.

This module changes the functionality when saving the hierarchy, making these longer URL strings compatibile.

### Before

![Before request_url table has been updated](https://raw.githubusercontent.com/markshust/magento2-module-hierarchycomplexidcompatibility/master/docs/before.png)

### After

![After request_url table has been updated](https://raw.githubusercontent.com/markshust/magento2-module-hierarchycomplexidcompatibility/master/docs/after.png)


## Requirements

This module requires the hierarchy functionality which is only available in Magento Commerce.

## Installation

```
composer require markshust/magento2-module-hierarchycomplexidcompatibility
bin/magento module:enable MarkShust_HierarchyComplexIdCompatibility
bin/magento setup:upgrade
```

## Usage

This module has no configuration. Just install, then go to Admin > Content > Elements > Hierarchy, and re-save the hierarchy. The entire tree will be re-saved with the new request URLs.

In the event there are duplicate URLs in the tree, you will be notified. The hierarchy must not ever contain duplicate values for the request_path.

![Error](https://raw.githubusercontent.com/markshust/magento2-module-hierarchycomplexidcompatibility/master/docs/error.png)

## License

[MIT](https://opensource.org/licenses/MIT)
