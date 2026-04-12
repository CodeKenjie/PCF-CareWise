<?php require __DIR__ . "/../partials/header.php"; ?>
<main id="schedule">
    <section id="calendar" class="acrylic-bg">
        <div id="month">
            <button class="btn-circle btn-highlight">
                <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L9.41421 12L15.7071 18.2929C16.0976 18.6834 16.0976 19.3166 15.7071 19.7071C15.3166 20.0976 14.6834 20.0976 14.2929 19.7071L7.29289 12.7071C7.10536 12.5196 7 12.2652 7 12C7 11.7348 7.10536 11.4804 7.29289 11.2929L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289Z" fill="currentColor"></path> </g></svg>
            </button>
            <label id="date">MonthNow YearNow</label>
            <button class="btn-circle btn-highlight">
                <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 4.29289C8.68342 3.90237 9.31658 3.90237 9.70711 4.29289L16.7071 11.2929C17.0976 11.6834 17.0976 12.3166 16.7071 12.7071L9.70711 19.7071C9.31658 20.0976 8.68342 20.0976 8.29289 19.7071C7.90237 19.3166 7.90237 18.6834 8.29289 18.2929L14.5858 12L8.29289 5.70711C7.90237 5.31658 7.90237 4.68342 8.29289 4.29289Z" fill="currentColor"></path> </g></svg>
            </button>
        </div>
        <div id="weekdays">
            <span>Sun</span>
            <span>Mon</span>
            <span>Tue</span>
            <span>Wed</span>
            <span>Thur</span>
            <span>Fri</span>
            <span>Sat</span>
        </div>
        <div id="days">
            <span class="prev-days">30</span>
            <span class="prev-days">31</span>
            <span>1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
            <span>6</span>
            <span class="set">7</span>
            <span>8</span>
            <span>9</span>
            <span>10</span>
            <span>11</span>
            <span class="current">12</span>
            <span>13</span>
            <span>14</span>
            <span>15</span>
            <span>16</span>
            <span>17</span>
            <span>18</span>
            <span>19</span>
            <span>20</span>
            <span>21</span>
            <span>22</span>
            <span>23</span>
            <span>24</span>
            <span class="active">25</span>
            <span>26</span>
            <span>27</span>
            <span>28</span>
            <span>29</span>
            <span>30</span>
            <span>31</span>
            <span class="next-days">1</span>
            <span class="next-days">2</span>
        </div>
    </section>
    <section id="list" class="acrylic-bg">
        <ul id="collection">
            <li>
                <h3>nov 21, 2026</h3>
                <h3>firstname, lastname</h3>
                <h3>for:</h3>
                <div>
                    <button>edit</button>
                    <button>preview</button>
                    <button>delete</button>
                </div>
            </li>
        </ul>
    </section>
</main>
<?php require __DIR__ . "/../partials/footer.php"; ?>