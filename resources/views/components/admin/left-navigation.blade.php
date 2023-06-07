<!-- menu -->
<div class="menu-area">
<div class="closes"><i class="fa fa-times" aria-hidden="true"></i></div>

<!-- logo -->
<div class="logo">
<a href="{{ route('admin.dashboard') }}">
    <img class="small-logo" src="{{ asset('img/logo.png') }} "alt="logo">
    <img class="big-logo" src="{{ asset('img/logo.png') }} "alt="logo">
</a>
</div>
<!-- logo -->

<nav class="menu">
<ul>
    <li><a class="{{ $pageName == 'Dashboard'? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4.5C7.03711 4.5 3 8.53711 3 13.5C3 15.6709 3.77637 17.6631 5.0625 19.2188L5.27344 19.5H18.7266L18.9375 19.2188C20.2236 17.6631 21 15.6709 21 13.5C21 8.53711 16.9629 4.5 12 4.5ZM12 6C16.1514 6 19.5 9.34863 19.5 13.5C19.5 15.1992 18.9053 16.7432 17.9531 18H6.04688C5.09473 16.7432 4.5 15.1992 4.5 13.5C4.5 9.34863 7.84863 6 12 6ZM12 6.75C11.5869 6.75 11.25 7.08691 11.25 7.5C11.25 7.91309 11.5869 8.25 12 8.25C12.4131 8.25 12.75 7.91309 12.75 7.5C12.75 7.08691 12.4131 6.75 12 6.75ZM9 7.54688C8.58691 7.54688 8.25 7.88379 8.25 8.29688C8.25 8.70996 8.58691 9.04688 9 9.04688C9.41309 9.04688 9.75 8.70996 9.75 8.29688C9.75 7.88379 9.41309 7.54688 9 7.54688ZM15 7.54688C14.5869 7.54688 14.25 7.88379 14.25 8.29688C14.25 8.70996 14.5869 9.04688 15 9.04688C15.4131 9.04688 15.75 8.70996 15.75 8.29688C15.75 7.88379 15.4131 7.54688 15 7.54688ZM6.79688 9.75C6.38379 9.75 6.04688 10.0869 6.04688 10.5C6.04688 10.9131 6.38379 11.25 6.79688 11.25C7.20996 11.25 7.54688 10.9131 7.54688 10.5C7.54688 10.0869 7.20996 9.75 6.79688 9.75ZM16.9922 9.77344L12.75 12.2109C12.5303 12.082 12.2725 12 12 12C11.1709 12 10.5 12.6709 10.5 13.5C10.5 14.3291 11.1709 15 12 15C12.8203 15 13.4883 14.3408 13.5 13.5234C13.5 13.5146 13.5 13.5088 13.5 13.5L17.7422 11.0859L16.9922 9.77344ZM6 12.75C5.58691 12.75 5.25 13.0869 5.25 13.5C5.25 13.9131 5.58691 14.25 6 14.25C6.41309 14.25 6.75 13.9131 6.75 13.5C6.75 13.0869 6.41309 12.75 6 12.75ZM18 12.75C17.5869 12.75 17.25 13.0869 17.25 13.5C17.25 13.9131 17.5869 14.25 18 14.25C18.4131 14.25 18.75 13.9131 18.75 13.5C18.75 13.0869 18.4131 12.75 18 12.75ZM6.79688 15.75C6.38379 15.75 6.04688 16.0869 6.04688 16.5C6.04688 16.9131 6.38379 17.25 6.79688 17.25C7.20996 17.25 7.54688 16.9131 7.54688 16.5C7.54688 16.0869 7.20996 15.75 6.79688 15.75ZM17.2031 15.75C16.79 15.75 16.4531 16.0869 16.4531 16.5C16.4531 16.9131 16.79 17.25 17.2031 17.25C17.6162 17.25 17.9531 16.9131 17.9531 16.5C17.9531 16.0869 17.6162 15.75 17.2031 15.75Z" fill="#2A4385"/>
            </svg> <span class="hide-item">Dashboard </span></a></li>



        <!-- sub-menu --></li>
    <!-- <li><a class="{{ $pageName == 'Account'? 'active' : '' }}" href="{{ route('admin.account', ['id' => 1]) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.75C9.1084 3.75 6.75 6.1084 6.75 9C6.75 10.8076 7.67285 12.4131 9.07031 13.3594C6.39551 14.5078 4.5 17.1621 4.5 20.25H6C6 16.9277 8.67773 14.25 12 14.25C15.3223 14.25 18 16.9277 18 20.25H19.5C19.5 17.1621 17.6045 14.5078 14.9297 13.3594C16.3271 12.4131 17.25 10.8076 17.25 9C17.25 6.1084 14.8916 3.75 12 3.75ZM12 5.25C14.0801 5.25 15.75 6.91992 15.75 9C15.75 11.0801 14.0801 12.75 12 12.75C9.91992 12.75 8.25 11.0801 8.25 9C8.25 6.91992 9.91992 5.25 12 5.25Z" fill="#63729A"/>
            </svg> <span class="hide-item">Account </span></a></li> -->


            <li><a class="{{ $pageName == 'Account'? 'active' : '' }}" href="{{ route('admin.users.index')}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.75C9.1084 3.75 6.75 6.1084 6.75 9C6.75 10.8076 7.67285 12.4131 9.07031 13.3594C6.39551 14.5078 4.5 17.1621 4.5 20.25H6C6 16.9277 8.67773 14.25 12 14.25C15.3223 14.25 18 16.9277 18 20.25H19.5C19.5 17.1621 17.6045 14.5078 14.9297 13.3594C16.3271 12.4131 17.25 10.8076 17.25 9C17.25 6.1084 14.8916 3.75 12 3.75ZM12 5.25C14.0801 5.25 15.75 6.91992 15.75 9C15.75 11.0801 14.0801 12.75 12 12.75C9.91992 12.75 8.25 11.0801 8.25 9C8.25 6.91992 9.91992 5.25 12 5.25Z" fill="#63729A"/>
            </svg> <span class="hide-item">Users </span></a></li>

            
   

    <li>
        <a class="{{ $pageName == 'Page' || $pageName == 'Add Page' || $pageName == 'Update Page' || $pageName == 'Section' || $pageName == 'Add Section' || $pageName == 'Update Section' || $pageName == 'Faq' || $pageName == 'Add Faq' || $pageName == 'Update Faq' || $pageName == 'Gallery' || $pageName == 'Add Gallery' || $pageName == 'Update Gallery' || $pageName == 'Testimonial' || $pageName == 'Add Testimonial' || $pageName == 'Update Testimonial' || $pageName == 'Update Testimonial'? 'active' : '' }}" href="javascript:;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3C7.03711 3 3 7.03711 3 12C3 16.9629 7.03711 21 12 21C16.9629 21 21 16.9629 21 12C21 7.03711 16.9629 3 12 3ZM12 4.5C13.4766 4.5 14.8477 4.93945 16.0078 5.67188L15.3984 5.74219L15.5391 7.24219L14.7422 6.89062L14.0859 7.45312L14.2031 9L15.8203 8.48438L17.8359 9.14062L17.3203 10.0781L16.1016 9.32812L14.7891 9.51562L13.5 10.4766L12.7734 12.7266L14.2266 13.9219C14.2266 13.9219 15.7178 13.6641 15.7969 13.6641C15.876 13.6641 16.4297 15.0234 16.4297 15.0234L15.2344 18.7734C14.2588 19.2393 13.1572 19.5 12 19.5C11.7627 19.5 11.5283 19.4736 11.2969 19.4531L10.4766 18.0234L11.2734 15.0234L8.25 12.75H5.46094L4.73438 11.2734L6.75 9.67969L9.75 8.25L9.30469 6.25781L10.5938 5.97656L11.2031 6.82031L13.4531 6.39844L13.0547 4.66406L11.3906 4.54688C11.5898 4.53223 11.7949 4.5 12 4.5ZM11.1562 4.54688L9.98438 5.03906L9.42188 4.94531C9.97559 4.74316 10.5498 4.61426 11.1562 4.54688ZM4.54688 12.5859L5.27344 13.4297V14.9766L6.67969 16.5234H7.54688L9.67969 19.1484C6.84961 18.2314 4.78418 15.668 4.54688 12.5859Z" fill="#63729A"/>
            </svg> <span class="hide-item">CMS </span> <span class="drop-icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
        <!-- sub-menu -->
        <ul class="sub-menu" id="sub-menuu">
             <li><a class="{{ $pageName == 'Page'? 'active' : '' }}" href="{{ route('admin.pages.index') }}">Pages</a>
               
                 <!-- <ul   class="sub-sub-menu">
                    <li>a</li>
                    <li>a</li>
                    <li>a</li>
                </ul> -->

            </li>
             
        </ul>
        <!-- sub-menu -->
    </li>

   <li><a class="{{ $pageName == 'Lead'? 'active' : '' }}" href="{{ route('admin.ourservices.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm-6 4q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21H5Zm0-2h14V5H5v14ZM5 5v14V5Z"/></svg> <span class="hide-item">Services</span></a></li>



   <li><a class="{{ $pageName == 'Lead'? 'active' : '' }}" href="{{ route('admin.labors.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm-6 4q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21H5Zm0-2h14V5H5v14ZM5 5v14V5Z"/></svg> <span class="hide-item">Add Labour</span></a></li>

   <li><a class="{{ $pageName == 'Lead'? 'active' : '' }}" href="{{ route('admin.searchlabors.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm-6 4q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21H5Zm0-2h14V5H5v14ZM5 5v14V5Z"/></svg> <span class="hide-item">Search Labour</span></a></li>

   <li><a class="{{ $pageName == 'Lead'? 'active' : '' }}" href="{{ route('admin.invoice.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm-6 4q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21H5Zm0-2h14V5H5v14ZM5 5v14V5Z"/></svg> <span class="hide-item">Invoice Details</span></a></li>

   <li><a class="{{ $pageName == 'Lead'? 'active' : '' }}" href="{{ route('admin.paymentapproval') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm-6 4q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.588 1.413T19 21H5Zm0-2h14V5H5v14ZM5 5v14V5Z"/></svg> <span class="hide-item">paymentapproval</span></a></li>

   


    <li><a class="{{ $pageName == 'Update Settings'? 'active' : '' }}" href="{{ route('admin.setting.edit', ['id' => 1]) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.9297 2.97656C17.1445 2.97656 16.3594 3.28125 15.75 3.89062L3.89062 15.75L3.84375 15.9844L3.02344 20.1094L2.78906 21.2109L3.89062 20.9766L8.01562 20.1562L8.25 20.1094L20.1094 8.25C21.3281 7.03125 21.3281 5.10938 20.1094 3.89062C19.5 3.28125 18.7148 2.97656 17.9297 2.97656ZM17.9297 4.40625C18.3076 4.40625 18.6885 4.5791 19.0547 4.94531C19.7842 5.6748 19.7842 6.46582 19.0547 7.19531L18.5156 7.71094L16.2891 5.48438L16.8047 4.94531C17.1709 4.5791 17.5518 4.40625 17.9297 4.40625ZM15.2344 6.53906L17.4609 8.76562L8.39062 17.8359C7.89844 16.875 7.125 16.1016 6.16406 15.6094L15.2344 6.53906ZM5.20312 16.8281C6.10254 17.1914 6.80859 17.8975 7.17188 18.7969L4.71094 19.2891L5.20312 16.8281Z" fill="#63729A"></path>
            </svg> <span class="hide-item">General Settings </span></a></li>













    <li><a href="{{ route('logout') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3C7.03711 3 3 7.03711 3 12C3 16.9629 7.03711 21 12 21C15.0381 21 17.7305 19.4912 19.3594 17.1797L18.1406 16.3125C16.7842 18.2402 14.543 19.5 12 19.5C7.84863 19.5 4.5 16.1514 4.5 12C4.5 7.84863 7.84863 4.5 12 4.5C14.543 4.5 16.7812 5.75977 18.1406 7.6875L19.3594 6.82031C17.7305 4.50879 15.0381 3 12 3ZM17.5078 8.46094L16.4297 9.53906L18.1406 11.25H9V12.75H18.1406L16.4297 14.4609L17.5078 15.5391L20.5078 12.5391L21.0234 12L20.5078 11.4609L17.5078 8.46094Z" fill="#63729A"/>
            </svg> <span class="hide-item">Logout </span></a></li>
</ul>


</nav>
</div>
<!-- menu -->
