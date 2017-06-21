# "Imagery" picture gallery #


## Feature list ##

1. Directory imagery with source code  should be inside empty directory.
2. The page opens with category 'all' and missing directories are creatded.
3. Mutiple file upload to 
	1. to new category uploads to 'all' too
	2. to all category alone
4. Multiple marked checkboxes
	1. add to not existing category
	2. add to existing category
	3. delete from category
5. Paging
	1. No problem with page beyond range in url (&page=1000 or &page=-1000)
	2. categories, categories in url (e.g. &category=family)
	3. pictures
6. rss feed with latest 5 pictures. When missing, header part is copied from template.
7. responsive picture size and left floating picture list
	1. height is in stable ratio to hieght of viewing window (1/5) and witdh seems not necessary to be calculated to be proportional. Responsivity is instant and was tested in latest Firefox and IE.
8. Missing category deleted by other user is handled
9. Naming conflict of uploaded image is handled by numbering
10. Simple slideshow of chosen category.


## Possible extensions to current functionality ##

1. Deleting a category when empty.
3. Pagination with number input between arrows of a form e.g. < ?/13 > (question mark for input value)
4. Pagination when first and last image are causing turning page
5. Pagination with calculation of variable number of items per page dependent on web browser window dimensions. Those values can be sent by JS via cookies. It would work just on second refresh, perhaps possible to fix. Turning page should check if any picutres on previous page exists due to multitude of users. One picture from previous page could be included for feel of continuity. Without JS should be fixed number of pitures per page exceeding normal dimensions pictures 2 times. JS should hide extra pictures and give last item?
6. Larger paging buttons derived from size of viewing window with mobile phone in mind.
7. Large paging buttons on side. Bootstrap carousel can be considered.
8. Add and delete capability are already implemented but were not specified in the task.
9. 'all' category can be made hidden from category list since it has special purpose and already special separate position in the UI.
9. A picture could be shown in so called lightbox. Possible to extend by jQuery UI API.
10. Categories can be shown in tabs by use of jQuery UI API.
11. Category tree structure can bring complications to current solution and benefits are not clear. However it could be extended by different kind of super-categories which shows categories in seperate directory structure. In bookmarking system Delicious it is used under name tag lists.
12. Category tag list for a picture can be achieved by scan through category directories and displayed aside a picture when it is chosen together with above-mentioned Lightbox view.
13. Change of configuration settings  based on size of a window. There can be for example 2 settings. One for viewing on computer and other for mobile phone. Those setting values can respond to ratios of height/width of viewing window dymnamically. Current solution with one configuration for both cases seems set fine.
14. Alphabetic and time sorting of categories and files by server-side touch. For large amount of files it can be time consuming without database SQLite or MySQL.
15. Filtering category and file names per category.
16. Slideshow with jQuery cycle2 plugin and turning pages.

## Assessment of current solution ##
1. All basic operations Upload, Add, Delete are implemented.
2. Left float and proportional resizing of picture thumbnails can allow browsing on mobile phone. Not tested. Setting configuration values of height ratio of a thumbnail against vertical size of a window can influence that we can see more than one column of thumbnails on mobile phone, 2 or even 3 columns.
3. Needs adaptations for webhosts who prohibits CallbackFilterIterator, shell_exec, symlink and may be some problems on others than Windows 7 servers.
4. Rss feed works fine from start when it copies initial template.
5. Problems with uploading are sent to viewer but something blocks showing it. To be fixed.
6. Duplicated filename renaming of files with different content adds numbering to the filenames.
7. Slideshow is very simple just with pictures in the page of chosen category.
