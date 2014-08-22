cageo-wellpermittingtool
========================

description

This repository contains the source code associated with the automated well permitting tool hosted here:

http://utahdwr.groups.et.byu.net/app4/

This prototype system was developed for the Utah Division of Water Rights (UT-DWR) for running a MODFLOW model of Northern Utah County via a web interface to determine the impact on neighboring wells, springs, streams, etc from a new well or set of wells. The original code was developed by David Jones, a graduate student at Brigham Young University, under the direction of Dr. Norm Jones (no relation). This system was then implemented more extensively in a production system by David who now works for the UT-DWR.

This prototype system was published in the Computers and Geosciences Journal (CAGEO) under the title "A Cloud-based MODFLOW Service for Aquifer Management Decision Support" in 2014.

The code in this repository represents the html, php, javascript code and supporting files associated with the tool. In addition to these files, you would also need two additional things to fully implement the system:

1. An SQL database containing the wells table. An SQL query file to create this database will be added to this repository in the near future. Please note that will need to edit the php/dbinfo.php file to enter the ip address and the password to your database.

2. A python workflow for executing the model. This workflow will also be added to the repository soon. The workflow is based on ArcGIS geoprocessing and uses both ArcGIS and Arc Hydro GW geoprocessing tools. The server hosting this system needs to have ArcGIS installed, including the Arc Hydro GW extension.

This system is described in much more detail in David Jones's MS Thesis:

Jones, David J. (2012). A Server-Based Tool for Automating MODFLOW Simulations for  Well Permitting Decision Support  (MS), Brigham Young University.  

A PDF version of the thesis can be downloaded here:

https://app.box.com/s/20fsl805j7yghthmy533
