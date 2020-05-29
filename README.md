# iReserve
iACADEMY is an institution that aims to lead the societal innovation by honing students to be progressive and industry-ready. Having various specialized Computing, Business, and Design programs, the school undoubtedly has to cater to individuals who have different needs and demands. As a result, the school has vowed to provide its students cutting edge facilities to effectively support their academic journey. A lot of students make the most out of these benefits, reserving laboratories and rooms whenever possible to aid them in their academic tasks. However, despite these efforts to stem away from the traditional aspects of local education, the reservation process was all manual paperwork until early 2019. Even then, the first version of the system had a lot to improve on, leading the team to conduct a research on how the said system can be enhanced, hoping to improve the overall user experience of students and faculty members alike.

With all the gathered cues taken into consideration, iReserve was created to make approvals, bookings, and cross-referencing of reservations a lot easier. Aside from improving situations surrounding common annoyances (e.g. human error, reservation conflicts, and system unreliability), the enhanced system also now has three user roles in mind: the bookers (i.e. faculty, student body), the administrator, and the security personnel. Improved features include a simplified interface that follows the three-click user design rule and a separate room occupancy overview tailored for security monitoring. Trimestral class schedule blocking is also one of the new features added for the administrator privileges. Data sanitization measures were also used and tested against common vulnerabilities such as cross-site scripting, cross-site request forgery, and SQL injection, ensuring that all improvements were applied with security in mind.

## Scope and Limitation

iReserve is a room reservation system that will cater to the iACADEMY faculty and student body, created to improve the user experience and eradicate the flaws observed in the first version of the school portal as well as the Academics Department’s formerly paper-based processes. In order to allow efficient facilitation of room reservations, three entities will be able to utilize this web application, namely:
- the room manager/administrator, who will be responsible for approving and denying requests, insertion and deletion of rooms and class schedules, and booking of admin-hosted reservations (such as school events and admin meetings)
- the faculty and student body, collectively identified as the users, who will serve as the main source of special room requests and automatically approved normal room reservations
- the security personnel, who will be checking room occupancies, reservation details, and class schedules to perform better in their routine rounds and room monitoring duties

This system will not include user registration and revision, section and subject code validation, room information revisions, and authentication using an actual active directory in its scope. These limitations were derived from the following assumptions:
- records in the school’s active directory have already been synchronized for usage (users, courses, facilities, and subjects)
- repurposing of rooms might require renovation and/or new set of protocols, rendering related requests/reservations and class schedules null and void
- student records are limited to those who are currently enrolled
- campus layout will not need provision for new floors
- version 2 of the portal has not been released
- class schedule insertions will be performed before the term starts
- license for FullCalendar scheduler has been purchased
- SSL certificate has been issued

## Suggested Improvements

The following improvements have been suggested during the presentation to further improve the system:
- Minor UI modifications for accessibility (adaptive font size for visually impaired users and usage of ARIA for all disabled users)
- reason input/select on room deletion (e.g. maintenance, safety issues) to give detailed explanation as to why the room was disabled, especially for the instructor/s of the affected class schedule/s
