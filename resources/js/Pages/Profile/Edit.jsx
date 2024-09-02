import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';
import { Head, Link, usePage, useForm } from '@inertiajs/react';
import Header from '@/Components/Main/Header';
import PricingCard from '@/Components/Main/PricingCard';
import InputError from '@/Components/InputError';
import QRCode from "react-qr-code";
import 'react-notifications-component/dist/theme.css'
import { ReactNotifications, Store } from 'react-notifications-component'
import Webcam from 'react-webcam';
import { useState, useRef } from 'react';
import dummyImg from '../../Assets/Images/dummy.png';
import RechargeModal from '@/Components/RechargeModal';


export default function Edit({user, existing_package, profile_image, records, memberShipRecords, feeRecords}) {
    
    // const { existed_package } = usePage().props;
    const [ hasImage, setHasImage ] = useState(false)
    const webcamRef = useRef(null);
    const [ image, setImage ] = useState('');
    const [ captured, setCaptured ] = useState(false);
    const [ cam, showCam ] = useState(false);
    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString(); // Adjust locale or options if needed
    };

    const {data, setData, post, processing, errors, reset} = useForm({
        first_name: user.first_name || '',
        last_name: user.last_name || '',
        // email: '',
        phone: user.phone || '',
        country: user.country || '',
        city: user.city || '',
        current_password: '',
        new_password: '',
        image: profile_image || ''
    });

    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const capture = () => {
        const imageSrc = webcamRef.current.getScreenshot();
        setImage(imageSrc);
        setData('image', imageSrc);
        // showCam(false);
    };

    const handleCam = () => {
        if( cam == false ){
            showCam(true);
        }
        else {
            showCam(false);
        }
        
        
    }

    const closeCam = () => {
        showCam(false);
    }

    const patchUser = (e) => {
        e.preventDefault()

        post(route('profile.update'), {
            onSuccess: Store.addNotification({
                title: "Success",
                message: "Profile updated!",
                type: "success",
                insert: "top",
                container: 'top-right',
                dismiss: {
                    duration: 2000
                }
            }),
            onError: (errors) => console.log(errors)
        })
    }

    const redirectToHome = () => {
        window.location.href = route('home.home') + "#pricing"
    }

    const displayImage = user.image ? profile_image : dummyImg;

    // handle download invoice

    const downloadInvoice = () => {
        window.location.href = route('invoice.generate')
    }

    const generateStatement = () => {
        window.location.href = route('invoice.statement')
    }

    const packageData = {
        "title": existing_package?.title,
        "price": existing_package?.price,
        "duration": existing_package?.duration
    }

    const getQrOnMail = () => {
        window.location.href = route('qr.generate')
        setTimeout(() => {
            Store.addNotification({
                title: 'Success',
                message: 'Mail sent',
                type: 'success',
                insert: 'top',
                container: 'top-right',
                dismiss: {
                    duration: 2000
                }
            }, 2000)
        })
    }

    const handlePhone = (e) => {
        const value = e.target.value;
        const numericValue = value.replace(/[^0-9+()\s-]/g, '');
        setData('phone', numericValue);
        // console.log(numericValue);
    }

    // Recharge modal

    const [showModal, setShowModal] = useState(false);

    const handleRechargeClick = () => {
        setShowModal(true);
    };

    const handleCloseModal = () => {
        setShowModal(false);
    };

    const [activeTab, setActiveTab] = useState('profile'); // default tab

    const handleTabClick = (tabName) => {
        setActiveTab(tabName);
    };

    return (
        <div className="w-full">
            <Header />
             <div className="w-full container md:mx-auto">
            <Head title='Profile' />
            <ReactNotifications />
            

            <div className="w-full md:my-[1rem] p-3">
                <div className="md:flex items-start justify-between gap-5">
                    
                    {
                        user.status === 'Pending' ? (
                            <div className="text-2xl font-bold p-2">
                                Your request is in progress please wait
                            </div>
                        ) : (
                            <div className="md:w-[30%] w-full">
                                <div className="border w-full flex gap-3 p-5">
                                    {/*<h2 className="p-2 font-extrabold">*/}
                                    {/*    Balance: <span>${user?.balance}</span>*/}
                                    {/*</h2>*/}
                                    {/*<p onClick={handleRechargeClick}*/}
                                    {/*    className="flex items-center cursor-pointer text-white p-1 rounded bg-blue-500">*/}
                                    {/*    Recharge*/}
                                    {/*</p>*/}
                                    <RechargeModal
                                        show={showModal} onClose={handleCloseModal}
                                    />
                                </div>
                                
                                
                                {
                        existing_package ? 
                        (
                            <div className="bg-white md:w-full my-3 md:my-0 border p-2">
                                <h2 className="p-2 font-extrabold">Active package: <span>{existing_package?.package.title}</span></h2>
                                <div className="p-2 text-start text-black font-extrabold">
                                    Expired in {existing_package?.duration} days
                                </div>

                                <div className="p-2 border">
                                    <QRCode
                                        value={JSON.stringify(packageData)}
                                        style={{ textAlign: "center", width: "100%" }}
                                    />
                                    {/* <p>{qr}</p>
                                    <img src={qr} alt="" /> */}
                                    <button onClick={getQrOnMail} className="w-full bg-blue-600 p-2 rounded text-white font-bold my-3">
                                        Get QR on Email
                                    </button>
                                </div>
                                <div className="w-full flex justify-center gap-3">
                                    <button onClick={downloadInvoice} type="button" data-tooltip-target="tooltip-default" className="text-sm text-center w-full bg-blue-600
                                        p-1 my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                                    >
                                       Download Invoice
                                    </button>
                                    
                                    <button onClick={generateStatement} className="text-center w-full bg-blue-600
                                        p-1 text-sm my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                                    >
                                        Get Statement
                                    </button>
                                    <button className="text-center w-full bg-blue-600
                                        p-1 text-sm my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                                    >
                                        Sell Membership
                                    </button>
                                </div>
                                
                            </div>
                        ) :
                        (
                            <div className="bg-white md:w-full my-3 md:my-0 border rounded p-2">
                                <h2 className="p-2 font-extrabold">No Active Package</h2>
                                <div className="p-2 text-start text-black font-extrabold">
                                    {/* Expired in {existing_package?.duration} days */}
                                </div>
                                <div className="w-full flex justify-center">
                                    <button onClick={redirectToHome} className="text-center w-[50%] bg-blue-600
                                        p-2 my-5 text-white font-extrabold rounded transition-all delay-5 hover:bg-blue-500"
                                    >
                                        Buy Membership Now
                                    </button>
                                </div>
                            
                            </div>
                        )
                    }
                            </div>
                        )
                    }
                    
                    

                    <div className="p-2 md:w-[70%] bg-white border rounded">
                        <button
                                className={`p-2 font-bold ${activeTab === 'profile' ? 'border-b-2 border-blue-500 text-blue-500' : ''}`}
                                onClick={() => handleTabClick('profile')}
                            >
                                Profile
                        </button>
                        <button
                            className={`p-2 font-bold ${activeTab === 'details' ? 'border-b-2 border-blue-500 text-blue-500' : ''}`}
                            onClick={() => handleTabClick('details')}
                        >
                            Records
                        </button>
                        {activeTab === 'profile' && (
                            <div>
                                {/* Profile content */}
                                <div>
                            {cam ? (
                                <div className="w-[20%] border">
                                    {
                                        image ? (
                                            <img src={image} />
                                            
                                        ):(
                                            <div>
                                                {
                                                    user.status == 'Active' && (
                                                        <div>
                                                            <Webcam
                                                            className="w-full"
                                                            audio={false}
                                                            ref={webcamRef}
                                                            screenshotFormat="image/jpeg"
                                                            width={320}
                                                            height={240}
                                                        />
                                                        <button type="button" onClick={capture} className="cursor-pointer p-2 bg-blue-600 text-white m-2 rounded font-bold">
                                                            Capture
                                                        </button>
                                                        <button type="button" onClick={closeCam} className="cursor-pointer p-2 bg-red-600 text-white m-2 rounded font-bold">
                                                            Close
                                                        </button>
                                                        </div>
                                                        
                                                    )
                                                }
                                                
                                            </div>
                                            
                                        )
                                    }
                                    
                                    
                                </div>
                            ) : (
                                <div className="w-[20%]">
                                    {
                                        user.status == 'Active' && (
                                            <div className="w-full">
                                                {
                                                    user.image ?
                                                    (
                                                        <img className="w-full" src={profile_image} alt="Profile" />        
                                                    )
                                                    :
                                                    SS(
                                                        <img className="w-full" src={displayImage} alt="Profile" />
                                                    )
                                                }
                                            </div>
                                        )
                                    }

                                    
                                    
                                </div>
                                
                            )}
                        </div>

                    {!cam && !user.image && (
                        <button type="button" onClick={handleCam} className="cursor-pointer p-2 bg-blue-600 text-white m-2 rounded font-bold">
                            Upload
                        </button>
                    )}

                    {
                        user.status == 'Active' && (
                            <button type="button" onClick={handleCam}
                                className="w-fullcursor-pointer p-2 bg-blue-600 text-white m-2 rounded font-bold">
                                Update Image
                            </button>
                        )
                    }
                    
                    <form onSubmit={patchUser}
                            className="w-full p-2 flex flex-col items-start gap-3" action="">
                        <label htmlFor="Email">Email</label>
                        <input maxLength={16} type="email" disabled className="bg-red-200 w-full rounded border-gray-200"
                            defaultValue={user.email} />
                        <InputError message={errors.email} className="mt-2" />

                        <label htmlFor="FirstName">First Name</label>
                        <input maxLength={16} onChange={(e) => setData('first_name', e.target.value)}
                            type="text" className="w-full rounded border-gray-200"
                            value={data.first_name} />
                        <InputError message={errors.first_name} className="mt-2" />

                        <label htmlFor="LastEmail">Last Name</label>
                        <input maxLength={16} onChange={(e) => setData('last_name', e.target.value)}
                            type="text" className="w-full rounded border-gray-200"
                            value={data.last_name} />
                        <InputError message={errors.last_name} className="mt-2" />

                        <label htmlFor="Country">Country</label>
                        <input maxLength={16} onChange={(e) => setData('country', e.target.value)}
                            type="text" className="w-full rounded border-gray-200"
                                    value={data.country} />
                        <InputError message={errors.country} className="mt-2" />

                        <label htmlFor="Phone">Phone</label>
                        <input onChange={(e) => setData('phone', e.target.value.replace(/[^0-9+()\s-]/g, ''))}
                                type="text"
                                name="phone"
                                className="w-full rounded border-gray-200"
                                value={data.phone} />
                        <InputError message={errors.phone} className="mt-2" />

                        <label htmlFor="City">City</label>
                        <input maxLength={16} onChange={(e) => setData('city', e.target.value)}
                                type="text" className="w-full rounded border-gray-200" value={data.city} />
                        <InputError message={errors.city} className="mt-2" />

                        <label htmlFor="Current Password">Current Password</label>
                        <input onChange={handleChange} name="current_password"
                                type="password" className="w-full rounded border-gray-200" placeholder="*********" />
                        <InputError message={errors.current_password} className="mt-2" />

                        <label htmlFor="New Password">New Password</label>
                        <input name="new_password" onChange={handleChange}
                                type="password" className="w-full rounded border-gray-200" placeholder="*********" />
                        <InputError message={errors.new_passwoqrd} className="mt-2" />

                        <input onChange={(e) => setData('image', e.target.value)}
                            type="hidden" defaultValue={image}  name="image" />
                        <button type="submit"
                                className="w-full text-center bg-blue-600 rounded
                                shadow-md p-2 text-white font-bold transition-all delay-5 hover:bg-blue-700">
                                Update Profile
                            </button>
                    </form>
                                {/* Include your profile form and content here */}
                            </div>
                        )}

                        {activeTab === 'details' && (
                            <div>
                                {/* Details content */}
                                <div className="flex items-center justify-between">
                                    <h1 className="text-2xl font-bold p-2">Records</h1>
                                    <a href={route('user.download.statement')}
                                        className="bg-blue-500 text-white p-1 rounded transition-all delay-5 hover:bg-blue-600">
                                        Download Statement
                                    </a>
                                </div>

                                <div class="my-5 relative overflow-x-auto">

                                    <table className="w-full border">
                                        <thead className="border">
                                        <th className="border p-3">DATE</th>
                                        <th className="border p-3">Action</th>
                                        <th className="border p-3">Amount</th>
                                        <th className="border p-3">Paid</th>
                                        <th className="border p-3">Due</th>
                                        </thead>
                                        <tbody className="border">
                                        {
                                            records?.map((record, index) => (
                                                <tr className="border" key={index}>
                                                    <td className="p-3 text-center border">{formatDate(record.created_at)}</td>
                                                    <td className="p-3 text-center border">{record.action}</td>
                                                    <td className="p-3 text-center border">${record.total_amount}</td>
                                                    <td className="p-3 text-center border">

                                                        {record.paid_amount !== 0.00 ? `$${record.paid_amount}` : `$0.00`}
                                                    </td>
                                                    <td className="p-3 text-center border">
                                                        ${record.due_amount}
                                                    </td>
                                                </tr>
                                            ))
                                        }

                                        </tbody>
                                    </table>
                                </div>
                                {/* Include your details section here */}

                                {/* member ship checkouts */}
                                {
                                    existing_package && (
                                        <div>
                                        <h1 className="text-2xl font-bold p-2">Active Membership Record</h1>
                                        <div class="relative overflow-x-auto">

                                            <table className="w-full border">
                                                <thead className="border">
                                                    <th className="border p-3">DATE</th>
                                                    <th className="border p-3">PACKAGE</th>
                                                    <th className="border p-3">TOTAL</th>
                                                    <th className="border p-3">PAID</th>
                                                    <th className="border p-3">DUE</th>
                                                    <th className="border p-3">PAYMENT OPTION</th>
                                                    <th className="border p-3">ACTIONS</th>
                                                </thead>
                                                <tbody className="border">
                                            
                                                    <tr className="border bg-green-100">
                                                        <td className="p-3 text-center border">{formatDate(existing_package?.created_at)}</td>
                                                        <td className="p-3 text-center border">{existing_package?.package.title}</td>
                                                        <td className="p-3 text-center border">${existing_package?.checkout.grand_total}</td>
                                                        <td className="p-3 text-center border">
                                                            {
                                                                existing_package?.checkout.paid === null ? (
                                                                    <>$0.00</>
                                                                ):(<>${existing_package?.checkout.paid}</>)
                                                            }
                                                            
                                                        </td>
                                                        <td className="p-3 text-center border">
                                                        {
                                                                existing_package?.checkout.due < 0 ? (
                                                                    <>$0.00</>
                                                                ):(<>${existing_package?.checkout.due}</>)
                                                            }
                                                        </td>
                                                        <td className="p-3 text-center border uppercase">{existing_package?.checkout.payment_option}</td>
                                                        <td className="p-3 text-center border">
                                                            {
                                                                existing_package?.checkout <= 0 ? (
                                                                    <a href={route('checkout.edit', existing_package?.checkout.id)} className="cursor-pointer transition-all font-bold delay-5 bg-green-400 p-1 rounded">PAY</a>
                                                                )
                                                                : (
                                                                    <p className="bg-green-400 font-bold p-1 rounded-full">PAID</p>
                                                                )
                                                            }
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>

                                    )
                                }
                                
                                {/* Registration fee section */}
                                {
                                    feeRecords && (
                                        <div className="my-5">
                                            <div className="flex items-center justify-between">
                                                <h1 className="text-2xl font-bold p-2">Fee Record</h1>
                                                {/*<a href="" className="bg-blue-500 text-white p-1 rounded transition-all delay-5 hover:bg-blue-600">*/}
                                                {/*    Download Statement*/}
                                                {/*</a>*/}
                                            </div>

                                            <div class="relative overflow-x-auto">

                                            <table className="w-full border">
                                                <thead className="border">
                                                    <th className="border p-3">DATE</th>
                                                    <th className="border p-3">TOTAL</th>
                                                    <th className="border p-3">PAID</th>
                                                    <th className="border p-3">DUE</th>
                                                    <th className="border p-3">ACTIONS</th>
                                                </thead>
                                                <tbody className="border">

                                                    <tr className="border bg-green-100">
                                                        <td className="p-3 text-center border">{formatDate(feeRecords.created_at)}</td>
                                                        <td className="p-3 text-center border">${feeRecords.total_charge}</td>
                                                        <td className="p-3 text-center border">${feeRecords.paid}</td>
                                                        <td className="p-3 text-center border">
                                                            {
                                                                feeRecords.due < 0 ? 
                                                                (<>
                                                                    $0.00
                                                                </>):(<> ${feeRecords.due}
                                                                </>) 
                                                            }
                                                            
                                                        </td>
                                                        <td className="p-3 text-center border">
                                                            {
                                                                feeRecords.due == 0.00 ? (
                                                                    <p className="bg-green-400 p-1 rounded-full font-bold">
                                                                        PAID
                                                                    </p>
                                                                )
                                                                :(
                                                                    <a href={route('user.takeFee', feeRecords.id)}
                                                                        className="cursor-pointer text-gray-900 font-bold bg-green-400 p-1 rounded transition-all hover:bg-green-300">
                                                                        PAY
                                                                    </a>
                                                                )
                                                            }
                                                            
                                                        </td>
                                                        
                                                    </tr>
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    )
                                }
                                    
                                </div>
                                
                        )}
                    
                    </div>
                </div>
            </div>

        </div>
        </div>
       
    );
}
