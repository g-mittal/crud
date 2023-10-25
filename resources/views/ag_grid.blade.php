<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>Ag Grid App</title>
    <!-- Include the JS for AG Grid -->
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.min.noStyle.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script> --}}


    <!-- Include the core CSS, this is needed by the grid -->
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/styles/ag-grid.css"/>
    <!-- Include the theme CSS, only need to import the theme you are going to use -->
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/styles/ag-theme-alpine.css"/>
  </head>
  <body>
    <!-- Button to demonstrate calling the grid's API. -->
    <button onclick="deselect()">Deselect Rows</button>
    <!-- The div that will host the grid. ag-theme-alpine is the theme. -->
    <!-- The gid will be the size that this element is given. -->
    <div id="myGrid" class="ag-theme-alpine" style="height: 500px"></div>

    <?php
        $num = 4;
    ?>
    {{-- <script src="{{ asset('\Resources\Js\ag_grid.js') }}"></script> --}}
    <script type="text/javascript">
        class BtnCellRenderer {
	
          init(params) {
            this.params = params;

            this.eGui = document.createElement('button');
            this.eGui.innerHTML = 'Delete me!';

            this.btnClickedHandler = this.btnClickedHandler.bind(this);
            this.eGui.addEventListener('click', this.btnClickedHandler);
          }
          
          getGui() {
            return this.eGui;
          }
          
          btnClickedHandler(event) {
            this.params.clicked(this.params.value);
          }
          
          destroy() {
            this.eGui.removeEventListener('click', this.btnClickedHandler);
          }
        }

        // Function to demonstrate calling grid's API
        function deselect() {
            gridOptions.api.deselectAll()
        }

        // Grid Options are properties passed to the grid
        const gridOptions = {

          // each entry here represents one column
          columnDefs: [
            { 
              field: 'id', 
            },
            { field: "name" },
            { field: "price" },  //, rowGroup: true
            { field: "description" },
            // { 
            //   field: 'delete', 
            //   cellRenderer: BtnCellRenderer, 
            //   cellRendererParams: {
            //     clicked: function(field) {
            //       alert(`${field} was clicked`);
            //     }
            //   }
            // },
          ],

          // default col def properties get applied to all columns
          defaultColDef: {sortable: true, filter: true},

          rowSelection: 'multiple', // allow rows to be selected
          animateRows: true, // have rows animate to new positions when sorted

          // example event handler
          onCellClicked: params => {
            console.log('cell was clicked', params?.data)
          }
        };

        // get div to host the grid
        const eGridDiv = document.getElementById("myGrid");
        // new grid instance, passing in the hosting DIV and Grid Options
        new agGrid.Grid(eGridDiv, gridOptions);


        // Fetch data from server
        // fetch("https://www.ag-grid.com/example-assets/row-data.json")
        // .then(response => response.json())
        // .then(data => {
        //   // load fetched data into grid
        //   gridOptions.api.setRowData(data);

        //   console.log(data);
        // });
        
        var passedArray = <?php echo json_encode($products); ?>;
        // document.write(passedArray);

        // passedArray.forEach(element => {
        //   document.write(element.id, element.name);
        // });

        // gridOptions.columnApi.sizeColumnsToFit();
        gridOptions.api.setRowData(passedArray);


        console.log(passedArray);

        // const num = "<?php echo"$num" ?>";
        // document.write(num);

    </script>
  </body>
</html>