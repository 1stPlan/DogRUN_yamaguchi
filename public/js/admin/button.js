(function () {
  'use strict';

  $(initBootgrid);

  function initBootgrid() {
    if (!$.fn.bootgrid) return;
    $('#bootgrid-basic').bootgrid({
      templates: {
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    });
    $('#bootgrid-selection').bootgrid({
      selection: true,
      multiSelect: true,
      rowSelect: true,
      keepSelection: true,
      templates: {
        select: '<div class="custom-control custom-checkbox">' + '<input type="{{ctx.type}}" class="custom-control-input {{css.selectBox}}" id="customCheck1" value="{{ctx.value}}" {{ctx.checked}}>' + '<label class="custom-control-label" for="customCheck1"></label>' + '</div>',
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    });
    var grid = $('#bootgrid-button').bootgrid({
      formatters: {
        commands: function commands(column, row) {
          return '<a href="" class="btn btn-sm btn-info command-edit mr-2"><em class="far fa-file fa-fw"></em></a>' + '<a href="" class="btn btn-sm btn-danger command-delete mr-2"><em class="fa fa-trash fa-fw"></em></a>' + '<a href="" class="btn btn-sm btn-warning command-delete"><em class="fa fa-edit fa-fw"></em></a>';
        }
      },
      templates: {
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    }).on('loaded.rs.jquery.bootgrid', function () {
      /* Executes after data is loaded and rendered */
      grid.find('.command-edit').on('click', function () {
        console.log('You pressed edit on row: ' + $(this).data('row-id'));
      }).end().find('.command-delete').on('click', function () {
        console.log('You pressed delete on row: ' + $(this).data('row-id'));
      });
    });

    var grid = $('#bootgrid-button_user').bootgrid({
      formatters: {
        commands: function commands(column, row) {
          return '<a href="" class="btn btn-sm btn-warning command-delete mr-2"><em class="fa fa-edit fa-fw"></em></a>' + '<a href="" class="btn btn-sm btn-danger command-delete"><em class="fa fa-trash fa-fw"></em></a>';
        }
      },
      templates: {
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    }).on('loaded.rs.jquery.bootgrid', function () {
      /* Executes after data is loaded and rendered */
      grid.find('.command-edit').on('click', function () {
        console.log('You pressed edit on row: ' + $(this).data('row-id'));
      }).end().find('.command-delete').on('click', function () {
        console.log('You pressed delete on row: ' + $(this).data('row-id'));
      });
    });

    var grid = $('#bootgrid-button_event').bootgrid({
      formatters: {
        commands: function commands(column, row) {
          return '<a href="" class="btn btn-sm btn-warning command-delete mr-2"><em class="fa fa-edit fa-fw"></em></a>' + '<a href="" class="btn btn-sm btn-danger command-delete"><em class="fa fa-trash fa-fw"></em></a>';
        }
      },
      templates: {
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    }).on('loaded.rs.jquery.bootgrid', function () {
      /* Executes after data is loaded and rendered */
      grid.find('.command-edit').on('click', function () {
        console.log('You pressed edit on row: ' + $(this).data('row-id'));
      }).end().find('.command-delete').on('click', function () {
        console.log('You pressed delete on row: ' + $(this).data('row-id'));
      });
    });

    var grid = $('#bootgrid-button_post').bootgrid({
      formatters: {
        commands: function commands(column, row) {
          return '<a href="" class="btn btn-sm btn-warning command-delete mr-2"><em class="fa fa-edit fa-fw"></em></a>' + '<a href="" class="btn btn-sm btn-danger command-delete"><em class="fa fa-trash fa-fw"></em></a>';
        }
      },
      templates: {
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    }).on('loaded.rs.jquery.bootgrid', function () {
      /* Executes after data is loaded and rendered */
      grid.find('.command-edit').on('click', function () {
        console.log('You pressed edit on row: ' + $(this).data('row-id'));
      }).end().find('.command-delete').on('click', function () {
        console.log('You pressed delete on row: ' + $(this).data('row-id'));
      });
    });

    var grid = $('#bootgrid-button_contact').bootgrid({
      formatters: {
        commands: function commands(column, row) {
          return '<a href="" class="btn btn-sm btn-warning command-delete mr-2"><em class="fa fa-edit fa-fw"></em></a>' + '<a href="" class="btn btn-sm btn-danger command-delete"><em class="fa fa-trash fa-fw"></em></a>';
        }
      },
      templates: {
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    }).on('loaded.rs.jquery.bootgrid', function () {
      /* Executes after data is loaded and rendered */
      grid.find('.command-edit').on('click', function () {
        console.log('You pressed edit on row: ' + $(this).data('row-id'));
      }).end().find('.command-delete').on('click', function () {
        console.log('You pressed delete on row: ' + $(this).data('row-id'));
      });
    });

    var grid = $('#bootgrid-button_event_user').bootgrid({
      formatters: {
        commands: function commands(column, row) {
          return '<a href="" class="btn btn-sm btn-warning command-delete mr-2"><em class="fa fa-edit fa-fw"></em></a>' + '<a href="" class="btn btn-sm btn-danger command-delete"><em class="fa fa-trash fa-fw"></em></a>';
        }
      },
      templates: {
        // templates for BS4
        actionButton: '<button class="btn btn-secondary" type="button" title="{{ctx.text}}">{{ctx.content}}</button>',
        actionDropDown: '<div class="{{css.dropDownMenu}}"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown"><span class="{{css.dropDownMenuText}}">{{ctx.content}}</span></button><ul class="{{css.dropDownMenuItems}}" role="menu"></ul></div>',
        actionDropDownItem: '<li class="dropdown-item"><a href="" data-action="{{ctx.action}}" class="dropdown-link {{css.dropDownItemButton}}">{{ctx.text}}</a></li>',
        actionDropDownCheckboxItem: '<li class="dropdown-item"><label class="dropdown-item p-0"><input name="{{ctx.name}}" type="checkbox" value="1" class="{{css.dropDownItemCheckbox}}" {{ctx.checked}} /> {{ctx.label}}</label></li>',
        paginationItem: '<li class="page-item {{ctx.css}}"><a href="" data-page="{{ctx.page}}" class="page-link {{css.paginationButton}}">{{ctx.text}}</a></li>'
      }
    }).on('loaded.rs.jquery.bootgrid', function () {
      /* Executes after data is loaded and rendered */
      grid.find('.command-edit').on('click', function () {
        console.log('You pressed edit on row: ' + $(this).data('row-id'));
      }).end().find('.command-delete').on('click', function () {
        console.log('You pressed delete on row: ' + $(this).data('row-id'));
      });
    });

  }
})(); // DATATABLES
