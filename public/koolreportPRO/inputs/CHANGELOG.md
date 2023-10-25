# Change Log

## Version 6.2.0

1. Upgrade version of DateTimePicker

## Version 6.1.0

1. Add `type` property to TextBox to set type
2. Fixed: Wrong end date of thisMonth with DateRangePicker

## Version 6.0.0

1. `DateTimePicker`: Adding `disabled` property
2. `DateRangePicker`: Adding ability to convert php date time format to moment format in js
3. `DateRangePicker`: Fix issue of wrong calculated date for thisMonth() preset function
4. `DateRangePicker`: Add `template` option
5. Provide `disable()` client method to all inputs to disable for enable input widgets.
6. Added `frontText` and `backText` property to TextBox widget.
7. Fixed: Clear issue of wrong thisMonth() calculation of DateRangePicker
8. Added: Add bs4 template for CheckBoxList and RadioList

## Version 5.6.0

1. `BSelect`: Update to work with Bootstrap4
2. `DateRangePicker`: Adding customized calendar icon and caret icon

## Version 5.5.1

1. `DateRangePicker`: Fix the visibility issue with Bootstrap4

## Version 5.5.0

1. `DateRangePicker`: Upgrade to version 3.0.5

## Version 5.2.0

1. Fix the icons issue with new font-awesome 5
2. Upgrade to Select2 4.0.12
3. Solving Select2 scrolling to bottom when selected in Safari 

## Version 5.0.0

1. Fix the issue of CheckBoxList in Safari

## Version 4.5.0

1. Fix the RangeSlider range property
2. Fix the issue with reset function in BSelect, MultiSelect, Select2, TextBox that stop the `onReady` event.
3. `BSelect`: Fix the clientEvents
4. `Select2`: Make single select not select the first option by `"defaultOption"=>array()`
5. `BSelect`: Fix the empty selection
6. `Select2`: Fix the empty selection
7. `MultiSelect`: Fix the empty selection
8. `CheckBoxList`: Fix the empty selection


## Version 4.0.0

1. DateRangePicker:Fix the warning of moment because of date is not in correct format
2. CInputs: Fix the warning in internet explorer
3. Convert all widget to new loading methods
4. DateRangePicker: Able to set minDate and maxDate
5. DateRangePicker: Able to extend to set all extended options provided by native DateRagePicker
6. The use of Bindable trait in KoolReport is not compulsory.
7. DateTimePicker: Support Bootstrap 4
8. DateRangePicker: Support Bootstrap 4
9. BSelect: Support Bootstrap 4

## Version 3.5.0

1. Enable writing js function in options property


## Version 3.3.0

1. Make use of default dataSource from Widgets.
2. Improve the resource loading.
3. DateRangePicker: Use default language settings provided by Widget
4. Widget: Able to set language map directly in array form.


## Version 3.0.0

1. Add new `clientEvents` for all controls to handle events at client-side
2. Add `TextArea` input control.
3. Fix the `placeholder` settings for Select2

## Version 2.8.0

1. DateRangePicker: Fix the lastMonth() range
2. Select2: Fix the `placeholder` property.


## Version 2.7.0

1. Change `defaultOption` input format.
2. Make all select type controls have the same binding options
3. Add defaultOptions to `RadioList` and `CheckBoxList`

## Version 2.5.0

1. Add ability to set format for RangeSlider
2. Fix bug for MultiSelect

## Version 2.0.0

1. Select2
2. RangeSlider
3. BSelect

## Version 1.0.0

1. CheckBoxList
2. DateRangePicker
3. RadioList
4. DateTimePicker
5. MultiSelect
6. Select
7. TextBox