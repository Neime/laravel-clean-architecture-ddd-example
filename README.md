<p align="center"><strong>Clean Architecture, DDD et CQRS example with Laravel</strong></p>

## About

The application will provide a Rest JSON API allowing a user to book lessons for an instructor on defined schedules, these will be created by the instructor.

A lesson is available if it does not have a confirmed or pending reservation.

A lesson will have a price.

The validation of the reservation by the instructor of a lesson will result in the debit of the user's wallet.

The user will be able to fill his wallet in euros only.

## Event Storming / Sequence Diagram
    
![screenshot-excalidraw com-2023 03 23-15_43_02](https://user-images.githubusercontent.com/5405182/227239475-65db8fac-184c-4ca3-99a0-4b2db4828bbb.png)

(It would have been better to make a sequence diagram by use case and to do a real event storming)
    
## Use Cases

### Use Case 1

Application can create a user to be a teacher

### Use Case 2

Application can create a user to be a learner

### Use Case 3

Teacher create a lesson with a start date and hour and price

### Use Case 4

Learner add euros on his wallet

### Use Case 5

Learner see lessons available 

### Use Case 6

Learner book a lesson available if wallet is sufficient

### Use Case 7

Teacher validate a booking 

### Use Case 8

Transfert money to debit wallet of learner and credit wallet of techer and close it lesson

## Bounded Context & Domain

Learner (Bounded Context) : 

User (Domain)
- Use case 2

Booking (Domain)
- Use Case 5
- Use Case 6

Teacher (Bounded Context) : 

User (Domain)
- Use case 1

Lesson (Domain)
- Use Case 3
- Use Case 7

Bank (Bounded Context) :

Wallet (Domain)
- Use Case 4
- Use Case 8

## CQRS  (Command and Query)

### Learner Bounded Context

#### Command
CreateLearner : create a learner
BookLesson : book a lesson by a learner, booking is pending and payment status is new also, and send event

#### Query
GetLessonsAvailable : get all lessons available
GetBookings : get all booking create by learner

#### Event
LessonBooked : event to indicate a lesson has been booked

#### Consumer
-

### Teacher Bounded Conext

#### Command
CreateTeacher : create a teacher
CreateLesson : create a lesson by a teacher
ValidateBooking : validate a booking
RefuseBooking : refuse a booking

#### Query
GetBookingsPending : get all booking of its lessons pending validation and payment state pending

#### Event
BookingValidated : event to indicate a booking has been validated
BookingRefused : event to indicate a booking has been refused

#### Consumer
-

### Bank Bounded Context

#### Command
AddMoneyToWallet : add money to a wallet of an user
TransfertMoney : transfert money between wallet
AuthorizeTransaction : check if has enough money for a user to do a transaction, state new to pending
CreateTransaction : create transaction for a wallet with new state and price

#### Query
-

#### Event
TransactionAuthorized : event to indicate that a transaction is authorized

#### Consumer
LessonBookedConsumer : listen if a booking has been asked, create Transaction and authorize transaction 
BookingValidatedConsumer : listen if a booking has been validated and transfert money between learner wallet and teacher wallet
BookingRefusedConsumer : listen if a booking has been refused and cancel transaction
