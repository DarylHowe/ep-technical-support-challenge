# EasyPractice Technical Challenge

Welcome to the EasyPractice tech challenge! Below you'll find a list of tasks to complete on this project. Make sure you're familiar with Git, Laravel and Vue.js before starting. This challenge should take no more than 3 hours.

## Working on the challenge

1. Fork the repo, and then submit a Pull Request to your own fork
2. Copy `.env.example` to `.env`
3. Update the `.env` file to include the correct database connection details
4. Run `composer install`, `php artisan key:generate`, `php artisan migrate`, `npm install` and `npm run dev` (ignore the build warnings)
5. Run `php artisan db:seed` to populate the database
6. Open up the project in the browser and click on "Register" to create a new user. All the work will be done while logged in.
7. Code indentation should be set up at 4 spaces in both PHP and JS files.
8. Work through the tasks in a new branch named `challenge/{your-name}`. Commit as often as you like.
9. Once you have completed the tasks, create a **new Pull Request** and send us the link to it from your fork.

**Important**: Please DO NOT submit a Pull Request to the original repo, fork this one and submit a PR on your own repo :)

## Technical Support Challenge - Assessment Objectives
This technical support challenge evaluates candidates' ability to handle real-world support scenarios. We assess how candidates prioritize issues by distinguishing between critical system problems and individual user requests. Candidates should demonstrate clear problem-solving methodology, explain their thinking process, and justify their decisions about resource allocation.

Key evaluation areas include priority assessment, systematic problem analysis, solution development, and communication skills. We look for balanced judgment that considers both technical feasibility and business impact. While there are no strictly "right" answers, responses should show logical thinking and the ability to explain technical concepts clearly.

The challenge helps us identify candidates who can effectively troubleshoot issues while maintaining professional communication and documentation standards.

## The tickets

Please tackle each ticket in a different commit if possible.

### Support Ticket: Client Booking Visibility Issue 
- [ ] Please update ticket with findings and proposed solution:
```
Priority: Critical

What is the problem?:
When users visit a client's page in our system, they are unable to see that client's booking information. The booking data should be visible but nothing is displaying on the page.

What did I already do to try and solve it? (Ex.: recreate in own system, details gathered):
- Asked user to log out and log back in
- Checked with another user who has the same problem
- Confirmed with the user that they can see other parts of the client page
- Asked user to try a different browser but had the same issue

Example from the user (if necessary):
"When I click on any client, I can see their basic information, but the bookings section is completely empty."

What do I need help with now?:
Need guidance on troubleshooting why the booking data isn't being displayed.

--------------------------------------------------------------------------------
Technical Support Analysis - Daryl Howe | 4th Feb 2025

Findings:
- After inspecting the code, not being able to view any Client's bookings is the expected system behaviour.
- An update to the codebase is required to show Client booking on the UI.
- There is nothing further Support can do to troubleshoot the issue.
- The issue lies with the development/technical support team to implement a fix.

Proposed Solution:
- An update is required to show Client bookings on the UI.
- Currently, only Client data is passed to the frontend. We need Client data AND Client booking data to be passed to the frontend. 
- The UI / frontend code has already been written to display the Client booking information - an update is required in the ClientsController@show method to achieve the required functionality (ignoring tests / refactoring).
- As this is a 'Critical' ticket a suggested quick fix has been added to ClientsController@show
- As ticket item is priority 'Critical' this solution ignores writing tests and refactoring
```

### Support Ticket: Client Deletion Status Unclear
- [ ] Please update ticket with findings and proposed solution:
```
Priority: Medium

What is the problem?:
When users click to delete a client, nothing seems to happen on the screen. Users can't tell if the delete action worked or not, and they have to refresh the page to see if the client was actually removed.

What did I already do to try and solve it? (Ex.: recreate in own system, details gathered):
- Clicked delete button multiple times to see if anything happens
- Refreshed the page to check if client was actually deleted
- Tried deleting different clients to see if it happens every time

Example from the user (if necessary):
"I clicked to delete a client, but nothing changed on my screen. I wasn't sure if it worked or not. When I refreshed the page, the client was gone from the list, but it would be nice to know right away if the deletion worked."

What do I need help with now?:
Need the development team to add some kind of message or indication that lets users know when a client has been successfully deleted. Right now users are unsure if their action worked or not.

--------------------------------------------------------------------------------
Technical Support Analysis - Daryl Howe | 4th Feb 2025

Findings:
- Upon inspection I can confirm the reported behaviour.
- There has never been any feedback on the UI when deleting a Client.  

Proposed Solution: 
- A single ticket item should be created to cover the behaviour required to address the reported issue.
- Development work is required on both backend and frontend:     
    Backend:
        Response from ClientsController@destory currently returns 'Deleted' for all scenarios.
        Depending on outcome of ClientsController@destory we should instead be following HTTP response status code conventions https://developer.mozilla.org/en-US/docs/Web/HTTP/Status.
        This allows the UI to response to the various scenarios which might be encountered (e.g resource is not found, server error, access control/permission denied etc).
        Consider adding logging for error scenarios (resurce not found, server error etc).
        
    Frontend:
        Handle all possible response types from ClientsController@destory appropriately. 
     	If 200/success response from backend is received (i.e the Client was successfully deleted):
            Display a Toast/notification on the UI stating 'The Client "Example Client Name" was successful deleted.' (or similar messaging). 
            Check other parts of the system / system documentation to see if we have a 'Toast' or notification component that we can re-use for this. 
            Delete / remove the Client from the listing on UI so the page does not need to be refreshed.
        Else:
            Handle the response code scenario appropriately.
            Display a user friendly error message to the user detailing the issue.    


```
### SECURITY VULNERABILITY: Client Privacy Concern
- [ ] Please update ticket with findings and proposed solution:
```
Priority: Urgent

What is the problem?:
All users can see every client in the system, including clients they didn't create or aren't assigned to. This is causing privacy concerns as users should only be able to see their own clients.

What did I already do to try and solve it? (Ex.: recreate in own system, details gathered):
- Confirmed with several users that they can see everyone's clients
- Checked if there were any visible settings to limit client visibility
- Verified this happens for both new and existing users

Example from the user (if necessary):
"I can see all 500+ clients in the system, even ones from other departments and locations. I should only be able to see my own 50 clients. This doesn't seem right from a privacy perspective, and it makes it harder to find my actual clients in the list."

What do I need help with now?:
Need the technical team to implement proper privacy controls so users can only see their own clients or clients they're specifically assigned to. This is urgent as it's a privacy concern for our business.

--------------------------------------------------------------------------------
Technical Support Analysis - Daryl Howe | 4th Feb 2025

Findings:
- Upon inspection I can confirm the reported behaviour.
- It appears privacy controls have never been implemented - this is new development work.

Clarifications:    
- I would discuss with team lead / colleague to check who is responsible for carrying out this work (assuming the ticket has been created by Support team).    
- I would get expansion on what is meant by 'clients they're specifically assigned to' as this suggested we would need to implement a way to assign/unsassign Users to Clients.  
        
Proposed Solution:       
- The work related to this ticket could be broken into 2 items:
    
    Item 1.
        Users should only see Clients that they have created.
        - There are two main scenarios we should consider here: 
                1. Exising Users/Clients
                    We must have a way to assigning existing Clients to Users so they don’t lose access when update is rolled out. 
                    This is an important element to this item.
                    Possible Solution: 
                        - Admins re-assign exisiting Users to existing Clients post rollout.
                        - Exisiting Users loose access to all Clients and must request access.
                        
                2. New Users/Clients 
                    Ensuring that new clients are properly linked to the users who create them moving forward.
                    This is more straight forward to implment.
                    We need too link Users and Clients (in DB) when a new Client is being created.  
    
    Item 2. 
        We should be able to assign Clients to Users (assuming that this is required functionality post follow up with Support/Product team)


- Implementation (additional info for challenge purposes):
    Database updates:
	- We need a way to connect/link Clients to Users: 
	    Create a new DB pivot table (many-to-many) called 'ClientUser'.
		This table allows Users to be assigned/unassigned to the Clients.
		This approach allows a single Client to be assigned to multiple users.
	- We could also track who created the Client (although not necessarily required but may be helpful/used in the future, confirm with product):
		If confirmed, add a column on the clients table named 'created_by_user_id' 

    Backend Updates:
        - Access control:
            When creating a Client (ClientsController@store), assign authenticated user to the Client via ClientUser pivot table (potentially 'created_by' or 'created_by_user_id' also)
            When displaying the listing of Clients (ClientsController@index) we should only show Clients assigned to the User (using the ClientUser pivot table). 
            We need to implement access control on routes such as 'ClientsController@show', 'ClientsController@destroy'
                Only users who have been assigned to the Client should be able to successfully call these routes (assuming this behaviour for purposes of challenge)
            We may need to implment roles/permissions for who can assign/unsassign users to and from Clients
	    
    Frontend Updates:
	    We may require a UI component/panel to assign/unassign Users to and from Clients.
	    Potentially, only an Admin would have access to this page/panel/component.  
		    
```

### Support Ticket: Request for Booking Timeline Filter
- [ ] Please update ticket with findings and proposed solution:
```
Priority: Low

What is the problem?:
One user has requested an easier way to separate future bookings from past bookings, suggesting a filter to quickly view upcoming or past appointments.

What did I already do to try and solve it? (Ex.: recreate in own system, details gathered):
- Asked if other users have reported similar requests (none have)
- Checked if the current system prevents viewing necessary booking information (it doesn't)
- Verified users can still access all booking information, just requires scrolling through the list

Example from the user (if necessary):
"It would be nice if we could have a way to just see upcoming bookings without having to look through all the old ones. Maybe a filter or something? Right now I have to scroll through everything to find future appointments."

What do I need help with now?:
Need assessment from the technical team on:
1. Whether implementing a timeline filter is worth the development resources
2. How many users might actually use this feature
3. If this should be prioritized given that only one user has requested it and the current system, while less convenient, still allows users to access all booking information

--------------------------------------------------------------------------------
Technical Support Analysis - Daryl Howe | 4th Feb 2025


Responose To Assessment Questions:

1. Whether implementing a timeline filter is worth the development resources:
        We could consider implmenting this feature if:
            No other items of higher priority exists.
            This is a very high value client making the request and we believe the feature is of high value to them. 
            Other users are requesting this feature.
            Product believes this feature would be of high enough value to end user(s). 

2. How many users might actually use this feature:
        The research you have already completed is likely the best way to find this out. 
        Considering asking other members of the support team if they have had Clients requesting a similar feature. 
        Please report back here if it seems like there have been many requests for it.  

3. If this should be prioritized given that only one user has requested it and the current system, while less convenient, still allows users to access all booking information:
    It should not be prioritized as the user is not blocked and they still have the ability to achieve the outcome they desire.
    It should remain as 'Low' priority until we have further requests for this feature. 
    If we get more requrest we can raise the priority level.
    If any of the conditions in responose to your first question have been met then we should consider re-prioritising. 

Proposed Solution:
   A quicker and also effective solution would be to order the bookings by date instead of implementing a filter. 
   1. Sort the bookings from the farthest future date to the most recent past date
        - This is likely the simplest, quickest solution to implment (from development perspective). 
        - This solution will make it very easy to see future vs past bookings. 
        - This solution will benifit all Clients 
         -This solution will would be the standard/expect behaviour for this type of listing.
        - Discuss with product as currently implmentation is quite bad from UX perspective, I personally believe this update would help/benifit all of our users.
        - Otherwise keep priority for this item as low until further requests come in
        
   2. Tracking future requests for this feature
        - If we receive more requests for this specific behaviour in the future we should re-prioritize this item.  
   
   
```

### Support Ticket: System "Freezes" During Client Updates
- [ ] Please update ticket with findings and proposed solution:
```
Priority: Low

What is the problem?:
One user reported that sometimes when they try to update client information, the system appears to freeze and doesn't save their changes. They have to refresh the page and enter the information again.

What did I already do to try and solve it? (Ex.: recreate in own system, details gathered):
- Asked user about their internet connection when this happens
- Had them try clearing their browser cache
- Checked if they experience the same issue on different browsers
- Noted that the issue occurs more frequently when they're quickly clicking multiple times
- Tested on my computer and couldn't reproduce the issue

Example from the user (if necessary):
"Sometimes when I'm updating client details, nothing happens when I click save. The page just sits there, and I have to refresh and do everything again. It's really frustrating when I'm trying to quickly update information during a call with a client."

What do I need help with now?:
Need guidance on whether this is:
1. A system issue that needs fixing
2. A user training opportunity about proper system interaction
3. A potential local issue with the user's device or internet connection

Note: User mentioned they're working from home using satellite internet, and the issue seems to happen more when their connection is slow.

--------------------------------------------------------------------------------
Technical Support Analysis - Daryl Howe | 4th Feb 2025

Findings:
- There does not seem to be a way to 'update' the Clients, only create new ones. 
- I have checked routes/controllers/UI and cannot find a way to do this.   
                    
Questions to Support:
- Can you please explain how we can update Clients (likely directly message / email Support to speed process).
- You asked several questions to the user but have not provided their response. Could you please report back on their responses.
- Have we had any other users encounter/report this issue?
   
Proposed Solution:
- Please ask the user to connect to an alternative stronger internet connection (if possible) and report back. 
- Unable to offer any other proposal until I can attempt to replicate the issue (Client update function is non existing). 

Additional:
- For purpose of this test I will assume the update functionality is similar to the 'Create Client' functionality and is excluded from the challege project for alternative reason.
- Since the user is on satellite internet and it cannot be replicated their connection may be what is causing the issue. This is likely a local issue with the user's device or internet connection.
- The system UI could likely be improved to give feedback to the end user on what is happening, this would provide a signigicatly better UX to this and other users:
    - When a user clicks save/update:
        1. Disable the save/update button to stop users re-submitting request
        2. Display a saving UI component (similar to loading component, but when saving/updating data)
        3. Display an Toast/notification (after update response received) to let the user know the outcome of the update
            - Consider if we want to navigate back to the listing UI after update is successfully performed
            
    

```

## Thank You!!

Thank you so much for participating in this tech challenge. Hope you had fun! If you have any questions or suggestions, please email us at development@easypractice.net
