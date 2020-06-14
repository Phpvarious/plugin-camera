# Changelog Camera

>**Important**
>
>As a reminder if there is no information on the update, it means that it only concerns the updating of documentation, translation or text

# 06/14/2020

- Improvement of the system for cleaning video stream files (note that the function is still in beta, it is possible that our setting is a little too aggressive)
- Correction of a bug on the recovery of movement information from foscam HD cameras
- Fixed a problem if a non admin user wanted to watch the video stream
- Correction of display bug on design in "flux only" mode"
- Bugfix

# 11/11/2020

- Adding configuration
- Possibility to see the camera in video stream (and no longer frame by frame) - Beta
- Redesign of the camera pre-configuration system

# 05/11/2020

- Return of the ONVIF discovery function (thanks @Aidom)
- Possibility to use commands (script type) for camera control

# 10/17/2019

- Optimization of the cleaning function of camera capture files

# 10/10/2019

- Correction of a bug on the taking of video under debian 10

# 09/25/2019

- Bug fix on rtsp in debian 10

# 09/23/2019

- Bugfix
- Addition of a field to put video stream options (rtsp)

# 09/20/2019

- Bugfix

# 09/14/2019

 - Fixed a bug where the cronHourly task of the camera plugin could not finish
 - Correction of a bug on the preview of the capture history

# 08/28/2019

- Improved rtsp support
- Bugfix

# 06/06/2019

- Correction of a problem if there are &amp; in the url of stream rtsp
- Improved security on the video stream
- Fixed a problem if there are spaces in the video stream url

# 01/21/2019

- Updating the doc
- Correction of a bug on the panel

# 01/17/2019

- Updating the doc
- Fixed a problem with the configuration of Wanscam q3 (s)

# 01/15/2019

- Addition of the Wanscam q3 camera (s)
- Mode selection automatically based on capture url and video stream (RTSP)
- Bugfix
- Added replacement for #username# and #password# in orders
- Correction of a dependency problem

# 06/01/2018

- Redesign of the panel, we now choose the number of cameras per line in the plugin configuration, their size is calculated automatically
- Mobile widget improvement
- Support for RTSP / MJPEG video streams ... Please note that there is a conversion done. This is only to be used if you have no choice, you should use snapshots (faster and less load on Jeedom)

# 04/03/2018

- Documentation update

# 03/10/2018

- Updating the doc
- Code optimization

# 03/05/2018

- Bugfix

# 02/12/2018

- Bugfix
- Addition of an option to deactivate any image compression on the Jeedom side
