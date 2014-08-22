/*

This script populates the HTML well table.  It looks for a TBODY element with the id 'tbody_databaseWells' and 
populates it with a header row and data rows.  The script also enables database edits, requiring the dialog box with 
an id of 'editRowDialog'.


*/



  var wellTableData;

  function populateTable(){


    dojo.xhrGet({

      url: "php/WellTable_json.php",
      handleAs: "json",
      load: function(result) {
        wellTableData = result;
        try{

          // Delete Existing rows:
          dojo.empty(  dojo.byId("tbody_databaseWells")  );


          // Create some HTML for a header row that will be added to each table
          fieldNameHTML = ""

          // Populate the header row
          for(var i=0; i<result.fieldNames.length; i++)
            fieldNameHTML += "<th>" + result.fieldNames[i] + "</th>";
          fieldNameHTML += "<th></th><th></th>"

          // Append the header row DOM node to the table
          dojo.create("tr", {innerHTML: fieldNameHTML, className:"databaseWells" }, dojo.byId("tbody_databaseWells"), "last");


          // Add rows for each well
          for (var i=0; i < result.data.length; i++){

            wellRowHTML = "";

            for(var j=0; j<result.fieldNames.length; j++)
              wellRowHTML += "<td>" + result.data[i][j] + "</td>";

            editData = {id:result.data[i][0], 
                        data:result.data[i]
            };

            // Add Edit link
            wellRowHTML += "<td><a href='javascript:void(0)' onclick='editRow(" + i + " )'>Edit</a></td>"

            // Add Delete link
            wellRowHTML += "<td><a href='javascript:void(0)' onclick='deleteRow(" + result.data[i][0] + " )'>Delete</a></td>"

            dojo.create("tr", {innerHTML: wellRowHTML, className:"databaseWells" }, dojo.byId("tbody_databaseWells"), "last");

          }

          // Add a single 'Add Row' link at bottom of table within a new row
          newWellLinkRowHTML = "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
          newWellLinkRowHTML += "<td><a href='javascript:void(0)' onclick='addRow()'>Add Row</a></td><td></td>";
          dojo.create("tr", {innerHTML: newWellLinkRowHTML }, dojo.byId("tbody_databaseWells"), "last");

        }
        catch(error){
          alert(error.message + "\nCould not print well table.")
        }
      },
      error: function(error) {
        alert(err.message + "\nCould not read well table.")
      }

    });

  }


  function editRow(row){

    dijit.byId("editRowDialog").show();

    dijit.byId("edit_WellID").set({ value: wellTableData.data[row][0] });
    dijit.byId("edit_Latitude").set({ value: wellTableData.data[row][1] });
    dijit.byId("edit_Longitude").set({ value: wellTableData.data[row][2] });
    dijit.byId("edit_Flow").set({ value: wellTableData.data[row][3] });
    dijit.byId("edit_ScreenTop").set({ value: wellTableData.data[row][4] });
    dijit.byId("edit_ScreenBotm").set({ value: wellTableData.data[row][5] });
    dijit.byId("edit_ApplicationID").set({ value: wellTableData.data[row][6] });

  }


  function submitEdits( content ){
  /*
   *  called when the user clicks the OK button to submit the edit dialog
   *  it's used for both updates an existing row and to insert a new row, depending if there is a WellID or not
   */

    eval("var params = "+ content);

    if( dijit.byId("edit_WellID").get("value").length > 0){
    // Update an existing row if the WellID is available

      // Most of the params are passed with 'content' from the form, but because the WellID textbox is
      //  disabled, it is not automatically included and rather needs to be manually added
      params.Well_ID = dijit.byId("edit_WellID").get("value");
 
      dojo.xhrGet( {
        url: 'php/WellTable_UpdateRow.php',
        content: params,
        load: function(data) {

          // Refresh the table to show the updated values
          populateTable();

        },
        error: function(data) { alert(data) }
      });
    }
    else{
    // Create a new row if the WellID is not available

      dojo.xhrGet( {
        url: 'php/WellTable_InsertRow.php',
        content: params,
        load: function(data) {

          // Refresh the table
          populateTable();

        },
        error: function(data) { alert(data) }
      });
    }

  }

  function deleteRow( wellId ){

    if (!confirm("Delete Well_ID " + wellId +" from the database?")){
      return void(0);
    }

    dojo.xhrGet( {
      url: 'php/WellTable_DeleteRow.php',
      content: {"Well_ID": wellId},
      load: function(data) {

        // Refresh the table
        populateTable();

      },
      error: function(data) { alert(data) }
    });

  }

  function addRow(){


    dijit.byId("editRowDialog").show();

    dijit.byId("edit_WellID").set({ value: "" });
    dijit.byId("edit_Latitude").set({ value: "" });
    dijit.byId("edit_Longitude").set({ value: "" });
    dijit.byId("edit_Flow").set({ value: "" });
    dijit.byId("edit_ScreenTop").set({ value: "" });
    dijit.byId("edit_ScreenBotm").set({ value: "" });
    dijit.byId("edit_ApplicationID").set({ value: "" });


  }