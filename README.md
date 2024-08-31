This is the Final Repository for the Food Pantry.  A project started at Etown in CS 341 - Software Engineering in 2022.
It was the class project in 2023 and is currently in the process of rolling out in our on-campus food pantry in the Fall
of 2024.  This respository was created to support and track the bugs discovered in rollout.

This project has inventory tracking and reporting.  It allows users to scan id badges and login.
Users register and then can scan to fill their cart.
They then check out.  All data recorded should populate the reports area for Pantry staff.

Also a temperature sensor was built with a PiBoard and is operational in the pantry fidge to automate this task for staff.


Any questions please email Professor Nancy Reddig at reddign@etown.edu.


Currently known issues are part of the Sprint Task list for any team willing to take on the project at:

Task SSH-1	
It is reported that the id scanner is not working to log users into to the Ipad.  We need to test to confirm and then meet ITS there to resolve.

Task SSH-2	
Javita would like more granularity on the Temperature Chart.  (Basically Click on a date and see all temps for that day by hour.  Maybe to click even on more layer deeper).

Task SSH-3	
The CHECKOUT feature doesn't clear the cart or add the items from the cart to the other table.  This is a series of SQL statements in on file that is not working.
This would take examination of the Data Model verses the queries to determine the bug.  A change to the data model late in development is most likely the cause.

Task SSH-4	
We need to print labels for all inventory items to place on the shelfs. A labels button that exports the name, number, and barcode would be best for this.

Task SSH-5	
Someone needs to help the food pantry staff enter all the inventory items into the system and train them on how the system will work to get it up and running.

 

