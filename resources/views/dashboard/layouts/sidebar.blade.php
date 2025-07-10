<aside
    class="fixed left-0 top-0 z-40 h-screen w-52 -translate-x-full transition-transform sm:w-56 sm:translate-x-0 md:w-64"
    id="separator-sidebar" aria-label="Sidebar">
    <div class="h-full overflow-y-auto bg-gray-50 px-3 py-4">
        <h2 class="mb-3 text-center text-xl font-semibold text-gray-900 md:text-2xl">Employee
                Benefits
        </h2>
        <ul class="space-y-2 px-1 font-medium">
            @role('admin')
                <li>
                    <a class="{{ request()->routeIs('employee.*') ? 'text-blue-500' : 'text-gray-900' }} group flex items-center rounded-lg p-2 hover:bg-gray-100"
                        href="{{ route('employee.index') }}">
                        <svg class="h-5 w-5 flex-shrink-0 transition duration-75" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Data Karyawan</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('benefit.*') ? 'text-blue-500' : 'text-gray-900' }} group flex items-center rounded-lg p-2 hover:bg-gray-100"
                        href="{{ route('benefit.index', ['status' => 'menunggu']) }}">
                        <svg class="h-5 w-5 flex-shrink-0 transition duration-75" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 3c0-.6.4-1 1-1h6c.6 0 1 .4 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-3 8c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2 1 1 0 1 0 0-2Zm2 5c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2 1 1 0 1 0 0-2Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Data Tunjangan</span>
                    </a>
                </li>
            @endrole

            @role('employee')
                <li>
                    <a class="{{ request()->routeIs('request*') ? 'text-blue-500' : 'text-gray-900' }} group flex items-center rounded-lg p-2 hover:bg-gray-100"
                        href="{{ route('request') }}">
                        <svg class="h-5 w-5 flex-shrink-0 transition duration-75" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11 16.5a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0Zm4.5 2.5v-1.5H14v-2h1.5V14h2v1.5H19v2h-1.5V19h-2Z"
                                clip-rule="evenodd" />
                            <path d="M3.987 4A2 2 0 0 0 2 6v9a2 2 0 0 0 2 2h5v-2H4v-5h16V6a2 2 0 0 0-2-2H3.987Z" />
                            <path fill-rule="evenodd" d="M5 12a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3">Permintaan</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('benefit.*') ? 'text-blue-500' : 'text-gray-900' }} group flex items-center rounded-lg p-2 hover:bg-gray-100"
                        href="{{ route('benefit.history', ['status' => 'menunggu']) }}">
                        <svg class="h-5 w-5 flex-shrink-0 transition duration-75" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3">Riwayat</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('notification.*') ? 'text-blue-500' : 'text-gray-900' }} group flex items-center rounded-lg p-2 hover:bg-gray-100"
                        href="{{ route('notification.index') }}">
                        <svg class="h-5 w-5 flex-shrink-0 transition duration-75" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                            <path
                                d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                        </svg>

                        <span class="ms-3">Notification</span>
                    </a>
                </li>
            @endrole
        </ul>
    </div>
</aside>
