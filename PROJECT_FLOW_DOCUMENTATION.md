# Airline CRM - Project Flow Documentation

## Project Overview
This is a comprehensive Customer Relationship Management (CRM) system specifically designed for the airline industry. The system manages relationships between airlines, travel agents, customers, and internal staff members.

---

## Technology Stack
- **Framework**: Laravel 10.x
- **PHP Version**: 8.1+
- **Database**: MySQL
- **Frontend**: Blade Templates (Laravel)
- **Authentication**: Laravel Sanctum
- **Permissions**: Spatie Laravel Permission
- **Additional Packages**: 
  - Laravel Log Viewer
  - Toastr (for notifications)

---

## System Architecture

### User Roles & Access Control
The system implements a multi-role architecture with the following user types:

1. **Super Admin** - Full system access
2. **Admin** - Administrative access with role-based permissions
3. **Employee** - Internal staff members with department-based access
4. **Agent** - Travel agents who work with airlines
5. **Customer** - End users who book through agents

---

## Core Modules & Workflows

### 1. Authentication & Authorization Module
**Flow**: 
- User logs in via `/admin/login` endpoint
- System validates credentials using Admin middleware
- Session established with role-based permissions
- Dashboard loaded based on user role

**Key Features**:
- Role-based access control (RBAC)
- Permission management for each role
- KYC document verification for admins
- Secure session management

---

### 2. Dashboard Module
**Flow**:
- Upon login, user redirected to role-specific dashboard
- System aggregates real-time statistics:
  - Employee count
  - Agent count  
  - Customer count
  - Ticket count
  - Group count
  - Lead count
  - Pending tasks
  - Leave management (today, tomorrow, next 7 days)
  - Upcoming holidays

**Key Features**:
- Real-time statistics display
- Leave management overview
- Holiday calendar integration
- Task status tracking

---

### 3. Employee Management Module
**Flow**:
1. **Employee Registration**
   - Admin creates employee profile
   - Assigns department and designation
   - Sets up user credentials
   - Configures department rights

2. **Employee Profile Management**
   - Personal information updates
   - Contact details management
   - Document uploads (read/sign acknowledgments)
   - Library access management

3. **Leave Management**
   - Employee submits leave request
   - Admin reviews and approves/rejects
   - Leave balance tracking
   - Leave type configuration (sick, casual, earned, etc.)

4. **Attendance Management**
   - Daily attendance tracking
   - Timesheet management
   - Overtime calculation
   - Shift scheduling

5. **Payroll Management**
   - Salary structure configuration
   - Payroll items setup
   - Payslip generation
   - Salary disbursement tracking

**Key Features**:
- Complete employee lifecycle management
- Department-based organization
- Leave type configuration
- Attendance tracking
- Comprehensive payroll system

---

### 4. Agent Management Module
**Flow**:
1. **Agent Registration**
   - Admin creates agent profile
   - Company details registration
   - IATA/GDS information
   - Head office contact details
   - Address information

2. **Agent Profile Management**
   - General information updates
   - Contact details management
   - Address updates
   - Product type assignments
   - Provision/PLI configuration

3. **Wallet Management**
   - Wallet creation for agents
   - Balance management
   - Transaction tracking
   - Wallet request processing

4. **Case History Management**
   - Case creation (ticket issues, booking problems)
   - Case updates and progress tracking
   - Case closure
   - Conversation logging

5. **Target Management**
   - Sales target assignment
   - Performance tracking
   - Product targets

**Key Features**:
- Comprehensive agent profiling
- Multi-address support
- Wallet and financial management
- Case tracking system
- Performance target management

---

### 5. Airline Management Module
**Flow**:
1. **Airline Registration**
   - Basic airline information
   - Airline details configuration
   - Head office contact details

2. **Fleet & Aircraft Management**
   - Aircraft registration
   - Fleet management
   - Contact details for fleet operations

3. **Staff Management**
   - Approved staff assignment
   - Staff rights configuration
   - Staff status management

4. **SLA & Agreement Management**
   - Service Level Agreement configuration
   - Agreement creation and management
   - Status tracking

5. **Special Fare Management**
   - Special fare creation for agents
   - Fare type configuration
   - Discount management
   - Agent-specific fare assignments

6. **Library Management**
   - Document library creation
   - Document uploads
   - Staff read/sign acknowledgments
   - Edition management

7. **Rules & Regulations**
   - Airline-specific rules
   - Regulation management
   - Status updates

**Key Features**:
- Complete airline profile management
- Fleet and aircraft tracking
- SLA and agreement management
- Special fare system
- Document library with acknowledgments
- Rules and regulations management

---

### 6. Customer Management Module
**Flow**:
1. **Customer Registration**
   - Profile creation
   - Contact details
   - Address information
   - Account setup

2. **Customer Profile Management**
   - Personal information updates
   - Contact management
   - Address updates
   - Account management

3. **Case History Management**
   - Case creation
   - Case updates
   - Case closure
   - Conversation tracking

4. **Role & Permission Management**
   - Role assignment
   - Permission configuration
   - Access control

**Key Features**:
- Customer profiling
- Multi-contact support
- Case tracking
- Role-based access

---

### 7. Ticket Management Module
**Flow**:
1. **Ticket Creation**
   - Air ticket booking
   - Ticket information capture
   - PNR management

2. **Ticket Processing**
   - Ticket validation
   - Status updates
   - Case integration

**Key Features**:
- Air ticket management
- PNR tracking
- Case integration

---

### 8. Flight Management Module
**Flow**:
1. **Flight Configuration**
   - Flight creation
   - Route management
   - Schedule setup

2. **Sector Management**
   - Sector definition
   - Route configuration
   - Status management

3. **Inventory Management**
   - Seat inventory tracking
   - Expiry management
   - Availability updates

**Key Features**:
- Complete flight management
- Sector configuration
- Inventory tracking
- Expiry alerts

---

### 9. Financial Management Module
**Flow**:
1. **Account Management**
   - Account creation
   - Account categorization
   - Status management

2. **Invoice Management**
   - Invoice creation
   - Invoice tracking
   - Payment processing

3. **Expense Management**
   - Expense categorization
   - Budget tracking
   - Expense reporting

4. **Commission Management**
   - Commission configuration
   - Agent commission tracking
   - Commission calculation

**Key Features**:
- Comprehensive accounting
- Invoice generation
- Expense tracking
- Commission management

---

### 10. Reporting Module
**Flow**:
1. **Staff Reports**
   - Employee performance reports
   - Attendance reports
   - Leave reports

2. **Agent Reports**
   - Agent performance reports
   - Sales reports
   - Commission reports

3. **Airline Reports**
   - Airline performance reports
   - Special fare reports
   - SLA compliance reports

4. **Customer Reports**
   - Customer activity reports
   - Booking reports
   - Case history reports

5. **Financial Reports**
   - Expense reports
   - Invoice reports
   - Payment reports
   - Payroll reports

**Key Features**:
- Multi-dimensional reporting
- Real-time data aggregation
- Export capabilities
- Custom report generation

---

### 11. Library & Document Management Module
**Flow**:
1. **Document Creation**
   - Library setup
   - Document upload
   - Categorization

2. **Document Distribution**
   - Staff assignment
   - Read acknowledgment
   - Sign acknowledgment

3. **Document Management**
   - Edition management
   - Status updates
   - Archive management

**Key Features**:
- Centralized document repository
- Read/sign tracking
- Edition control
- Airline and agent libraries

---

### 12. Sales Lead Management Module
**Flow**:
1. **Lead Creation**
   - Lead capture
   - Lead qualification
   - Lead assignment

2. **Lead Processing**
   - Staff assignment
   - Status tracking
   - Conversion management

**Key Features**:
- Lead tracking
- Staff assignment
- Conversion management

---

### 13. Delay Code Management Module
**Flow**:
1. **Delay Code Configuration**
   - Delay code creation
   - Category assignment
   - Status management

2. **Origin & Destination Management**
   - Location setup
   - Route configuration
   - Status management

**Key Features**:
- Delay code categorization
- Origin/destination management
- Route configuration

---

### 14. License Approval Module
**Flow**:
1. **License Application**
   - License request submission
   - Document upload
   - Information capture

2. **License Processing**
   - Review process
   - Approval/rejection
   - Status management

**Key Features**:
- License application tracking
- Document verification
- Approval workflow

---

## Database Structure Overview

### Core Tables
- **admins** - System administrators
- **employees** - Internal staff members
- **agents** - Travel agents
- **customers** - End users
- **airlines** - Airline companies
- **airline_details** - Detailed airline information
- **air_tickets** - Ticket information
- **cases** - Case history for agents/customers

### Supporting Tables
- **departments** - Organizational departments
- **designations** - Employee designations
- **leave_types** - Leave type configurations
- **holidays** - Holiday calendar
- **wallets** - Agent wallet management
- **special_fares** - Special fare configurations
- **slas** - Service Level Agreements
- **agreements** - Commercial agreements
- **aircraft** - Aircraft information
- **fleets** - Fleet management
- **flights** - Flight schedules
- **sectors** - Route sectors
- **inventory** - Seat inventory

---

## Security Features

1. **Authentication**
   - Secure login system
   - Session management
   - Password hashing

2. **Authorization**
   - Role-based access control
   - Permission management
   - Middleware protection

3. **Data Security**
   - Input validation
   - SQL injection prevention
   - XSS protection
   - CSRF protection

4. **Audit Trail**
   - Created_by/Updated_by tracking
   - Timestamp management
   - Soft delete functionality

---

## Key Integrations

1. **Email System** - Notification management
2. **File Storage** - Document management
3. **Calendar System** - Event and holiday management
4. **Logging System** - Activity tracking and debugging

---

## System Workflow Summary

### Typical User Journey (Admin)
1. Login to system
2. View dashboard with real-time statistics
3. Manage employees (hire, assign departments, manage leaves)
4. Manage agents (register, configure wallets, assign targets)
5. Manage airlines (configure fleets, set up SLAs, manage special fares)
6. Monitor cases and resolve issues
7. Generate reports for analysis
8. Manage system settings and permissions

### Typical User Journey (Agent)
1. Login to system
2. View assigned dashboard
3. Manage customer bookings
4. Track case history
5. Manage wallet balance
6. View special fares from airlines
7. Access airline library documents

### Typical User Journey (Employee)
1. Login to system
3. View assigned tasks
4. Submit leave requests
5. View payslips
6. Access company documents
7. Track attendance

---

## Development & Deployment

### Local Development
- PHP 8.1+ required
- MySQL database
- Composer for dependency management
- Laravel Artisan for CLI operations

### Key Commands
```bash
php artisan serve          # Start development server
php artisan migrate         # Run database migrations
php artisan db:seed         # Seed database with sample data
php artisan cache:clear     # Clear application cache
```

---

## Future Enhancement Opportunities

1. **Mobile Application** - Native mobile app for agents and customers
2. **API Integration** - GDS integration for real-time booking
3. **Payment Gateway** - Online payment processing
4. **Advanced Analytics** - AI-powered insights and predictions
5. **Multi-language Support** - Internationalization
6. **Real-time Notifications** - WebSocket integration
7. **Advanced Reporting** - Custom report builder
8. **Workflow Automation** - Automated business processes

---

## Support & Maintenance

### Regular Maintenance Tasks
- Database backups
- Log monitoring
- Security updates
- Performance optimization
- Bug fixes and enhancements

### Monitoring
- Application performance
- Error tracking
- User activity logs
- System health checks

---

## Conclusion

This Airline CRM system provides a comprehensive solution for managing relationships between airlines, travel agents, customers, and internal staff. The modular architecture allows for easy customization and scalability, while the robust security features ensure data protection and compliance with industry standards.

The system streamlines operations, improves communication, and provides valuable insights through comprehensive reporting and analytics capabilities.

---

*Document Version: 1.0*
*Last Updated: July 2026*
*Project: Airline CRM System*
