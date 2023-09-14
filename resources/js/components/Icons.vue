<template>
  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="hidden">
    <symbol id="delete" viewBox="0 0 24 24">
      <polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
    </symbol>

    <symbol id="search" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </symbol>

    <symbol id="add" viewBox="0 0 24 24">
      <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
    </symbol>

    <symbol id="edit" viewBox="0 0 24 24"> 
      <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
    </symbol>

    <symbol id="user" viewBox="0 0 24 24">
      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>
    </symbol>

    <symbol id="users" viewBox="0 0 24 24">
      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </symbol>

    <symbol id="info" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>
    </symbol>

    <symbol id="save" viewBox="0 0 24 24">
      <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline>
    </symbol>

    <symbol id="home" viewBox="0 0 24 24">
      <path d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z" />
    </symbol>

    <symbol id="check" viewBox="0 0 24 24">
      <polyline points="20 6 9 17 4 12"></polyline>
    </symbol>

    <symbol id="wishy" viewBox="0 0 24 24">
      <path class="svg-fill" d="M9.2,17.3l5.4-10c0.5-0.9-0.2-2-1.2-2H2.5c-1.9,0-3.1,2-2.2,3.7l4.5,8.3C5.7,19.1,8.2,19.1,9.2,17.3z"/>
      <path class="svg-fill" d="M17.3,6.7L13,14.6l1.5,2.7c0.9,1.7,3.4,1.7,4.4,0l4.8-8.9c0.8-1.4-0.2-3.1-1.8-3.1h-2.4 C18.6,5.4,17.8,5.9,17.3,6.7z"/>
    </symbol>

    <symbol id="link" viewBox="0 0 24 24">
      <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
    </symbol>

    <symbol id="lock" viewBox="0 0 24 24">
      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
    </symbol>

    <symbol id="unlock" viewBox="0 0 24 24">
      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
    </symbol>

    <symbol id="compass" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
    </symbol>

    <symbol id="setting" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
    </symbol>

    <symbol id="logout" viewBox="0 0 24 24">
      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line>
    </symbol>

    <symbol id="more-vertical" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
    </symbol>

    <symbol id="clock" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
    </symbol>

    <symbol id="send" viewBox="0 0 24 24">
      <line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
    </symbol>

    <symbol id="close" viewBox="0 0 24 24">
      <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>
    </symbol>
  </svg>
</template>